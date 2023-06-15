<?php 

 class Qa_vrs_right_party_v2 extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('Common_model');
       // $this->load->model('Qa_vrs_model');
    }

    public function createPath($path)
    {

        if (!empty($path))
        {

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

    private function vrs_upload_files($files,$path)   // this is for file uploaging purpose
  {
    $result=$this->createPath($path);
    if($result){
    $config['upload_path'] = $path;
    $config['allowed_types'] = '*';

      $config['allowed_types'] = 'm4a|mp4|mp3|wav';
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
  }

  //////////////right party version 2///////vikas starts/////
    public function add_edit_right_party_v2($right_party_v2_id){
        if(check_logged_in())
        {
            $current_user=get_user_id();
            $user_office_id=get_user_office_id();

            $data["aside_template"] = "qa/aside.php";
            $data["content_template"] = "qa_vrs/add_edit_right_party_v2.php";
            //$data["content_js"] = "qa_universal_js.php";
            $data["content_js"] = "qa_vrs_right_party_v2_js.php";
           // $data["content_js"] = "qa_vrs_2_js.php";
            $data['right_party_v2_id']=$right_party_v2_id;
            $tl_mgnt_cond='';

            if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
                $tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
            }else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
                $tl_mgnt_cond=" and assigned_to='$current_user'";
            }else{
                $tl_mgnt_cond="";
            }

            // $qSql = "SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,18) and is_assign_process(id,30) and status=1  order by name";

            // $data["agentName"] = $this->Qa_vrs_model->get_agent_id(18,71,30,88);

            $qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and (is_assign_client (id,18) or is_assign_client (id,30)) and (is_assign_process (id,30) or is_assign_process (id,88)) and status=1  order by name";
            $data['agentName'] = $this->Common_model->get_query_result_array($qSql);
            // $query = $this->db->query($qSql);
             //$data['agentName'] = $query->result_array(); 

              //$data['agentName'] = $this->Common_model->get_query_result_array($qSql);

            $qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";

            $data['tlname'] = $this->Common_model->get_query_result_array($qSql);

            $qSql = "SELECT * from
                (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
                (select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
                (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
                (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
                from qa_vrs_right_party_v2_feedback where id='$right_party_v2_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
            $data["right_party_v2_data"] = $this->Common_model->get_query_row_array($qSql);

            $curDateTime=CurrMySqlDate();
            $a = array();

            $field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";

            if($field_array['agent_id']){

                if($right_party_v2_id==0){
                    $field_array=$this->input->post('data');
                    $field_array['audit_date']=CurrDate();
                    $field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
                    $field_array['entry_date']=$curDateTime;
                    $field_array['audit_start_time']=$this->input->post('audit_start_time');
                    
                    if($_FILES['attach_file']['tmp_name'][0]!=''){
                        $a = $this->vrs_upload_files($_FILES['attach_file'], $path='./qa_files/qa_rp_vrs_v2/');
                        $field_array["attach_file"] = implode(',',$a);
                    }

                    $rowid= data_inserter('qa_vrs_right_party_v2_feedback',$field_array);
                    if(get_login_type()=="client"){
                        $add_array = array("client_entryby" => $current_user);
                    }else{
                        $add_array = array("entry_by" => $current_user);
                    }
                    $this->db->where('id', $rowid);
                    $this->db->update('qa_vrs_right_party_v2_feedback',$add_array);

                }else{

                    $field_array1=$this->input->post('data');
                    $field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
                    if($_FILES['attach_file']['tmp_name'][0]!=''){
                        if(!file_exists("./qa_files/qa_rp_vrs_v2/")){
                            mkdir("./qa_files/qa_rp_vrs_v2/");
                        }
                        $a = $this->vrs_upload_files( $_FILES['attach_file'], $path = './qa_files/qa_rp_vrs_v2/' );
                        $field_array1['attach_file'] = implode( ',', $a );
                    }

                    $this->db->where('id', $right_party_v2_id);
                    $this->db->update('qa_vrs_right_party_v2_feedback',$field_array1);
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
                    $this->db->where('id', $right_party_v2_id);
                    $this->db->update('qa_vrs_right_party_v2_feedback',$edit_array);

                }

                redirect('Qa_vrs');
            }
            $data["array"] = $a;

            $this->load->view("dashboard",$data);
        }
    }
 }
?>