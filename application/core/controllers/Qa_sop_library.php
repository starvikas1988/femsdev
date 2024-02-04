<?php 

 class Qa_sop_library extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
	}
	 
	public function index(){
		if(check_logged_in()){
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_sop_library/manage_sop.php";
			$data["content_js"] = "qa_metropolis_js.php";
			
			$data['process_list'] = $this->Common_model->get_process_for_assign();
			
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$cond="";
			
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
			
			if($from_date !="" && $to_date!=="" )  $cond= " Where (date(entry_date) >= '$from_date' and date(entry_date) <= '$to_date' ) ";
			
			$qSql = "Select *, (select name from process p where p.id=process_id) as p_name, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as entry_name from qa_sop_library $cond";
			$data["sop_data"] = $this->Common_model->get_query_result_array($qSql);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			
			$this->load->view("dashboard",$data);
		}
	}
	
	
	public function add_sop_library(){
		if(check_logged_in()){
			$current_user = get_user_id();
			$curDateTime=CurrMySqlDate();
			$log=get_logs();
			$a = array();
			
			if($current_user!=""){
				$field_array = array(
					"process_id" => trim($this->input->post('process_id')),
					"docu_name" => trim($this->input->post('docu_name')),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				$a = $this->sop_upload_files($_FILES['docu_upl']);
				$field_array["docu_upl"] = implode(',',$a);
				$rowid = data_inserter('qa_sop_library',$field_array);
			}
			redirect('qa_sop_library');
			$data["array"] = $a;
		}
	}
	
	
	private function sop_upload_files($files){
        $config['upload_path'] = './qa_files/sop_library/';
		$config['allowed_types'] = 'doc|docx|xls|xlsx';
		$config['max_size'] = '2024000';
		$this->load->library('upload', $config);
		$this->upload->initialize($config);

        $images = array();
        foreach ($files['name'] as $key => $image) {           
			$_FILES['images[]']['name']= $files['name'][$key];
			$_FILES['images[]']['type']= $files['type'][$key];
			$_FILES['images[]']['tmp_name']= $files['tmp_name'][$key];
			$_FILES['images[]']['error']= $files['error'][$key];
			$_FILES['images[]']['size']= $files['size'][$key];

            if ($this->upload->do_upload('images[]')) {
				$info = $this->upload->data();
				$images[] = $info['file_name'];
            } else {
                return false;
            }
        }
        return $images;
    }

	
	
 }
 
 ?>