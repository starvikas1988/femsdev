<?php 

 class Process_knowledge_test extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
		$this->load->model('Examination_model');
		$this->load->model('Questions_model');
		$this->load->library('excel');
		$this->objPHPExcel = new PHPExcel();
		
		$this->load->library("pagination");
	}
	 
	
	public function index(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa_boomsourcing_aside/aside.php";
			$data["content_template"] = "process_knowledge_test/dashboard.php";
			$data["content_js"] = "process_knowledge_test_js.php";
			
			$this->load->view("dashboard",$data);
		}
	}
	
	/**
	 *===========================
	 * Created By: SOURAV SARKAR
	 * Created On: 23-Aug-2022
	 *===========================
	 *  
	 **/

	public function getMonthlyTopTenScore(){

		$month = $this->input->post('selectedMonth');

		$current_user = get_user_id();
		$ops_cond="";
		if(get_global_access()!=1){
		    if(get_role_dir()=='manager' && get_dept_folder()=='operations'){

		        $ops_cond=" AND (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";

		    }else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){

		        $ops_cond=" AND assigned_to='$current_user'";

		    }else if(get_role_dir()=='agent' && get_dept_folder()=='qa'){

		        $ops_cond=" AND assigned_qa ='$current_user'";

		    }else if(get_role_dir()=='agent' && get_dept_folder()=='operations'){

		        $ops_cond=" AND agent_id='$current_user'";
		        
		    }else{
		        $ops_cond="";
		    }
		}

		$sql="SELECT au.id,au.assigned_user_id,concat(s.fname, ' ',s.lname) as name,s.xpoid,s.fusion_id,SUM(au.score) as score,SUM(de.total_score) as total_score,ROUND(((SUM(au.score)/SUM(de.total_score))*100),2) as score_percent FROM `assign_exam_to_user` au LEFT JOIN examinations de ON de.id=au.exam_id LEFT JOIN signin s ON s.id = au.assigned_user_id WHERE au.exam_given='Yes' AND MONTH(de.created_on) = ? AND YEAR(NOW()) $ops_cond GROUP BY au.assigned_user_id ORDER BY score_percent DESC LIMIT 10";

		$query = $this->db->query($sql,array($month));
        $data =  $query->result_array();

		$labels = array();
		$scorePercent = array();
		foreach($data as $score){
			$labels[] = $score['name'];
			$scorePercent[] = (float)$score['score_percent'];
		}

		echo json_encode(array('labels'=>$labels,'scorePercent'=>$scorePercent));
	}

	/**
	 *===========================
	 * Created By: SOURAV SARKAR
	 * Created On: 23-Aug-2022
	 *===========================
	 *  
	 **/

	public function get_pkt_agent(){

		$month = $this->input->post('selectedMonth');

		$current_user = get_user_id();
		$ops_cond="";
		if(get_global_access()!=1){
		    if(get_role_dir()=='manager' && get_dept_folder()=='operations'){

		        $ops_cond=" AND (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";

		    }else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){

		        $ops_cond=" AND assigned_to='$current_user'";

		    }else if(get_role_dir()=='agent' && get_dept_folder()=='qa'){

		        $ops_cond=" AND assigned_qa ='$current_user'";

		    }else if(get_role_dir()=='agent' && get_dept_folder()=='operations'){

		        $ops_cond=" AND agent_id='$current_user'";
		        
		    }else{
		        $ops_cond="";
		    }
		}

		$sql="SELECT au.id,au.assigned_user_id,concat(s.fname, ' ',s.lname) as name,s.xpoid,s.fusion_id,(SELECT concat(ss.fname,' ',ss.lname) FROM signin ss WHERE ss.id=s.assigned_to) as tl_name,SUM(au.score) as score,SUM(de.total_score) as total_score,ROUND(((SUM(au.score)/SUM(de.total_score))*100),2) as score_percent,SUM(CASE WHEN exam_given = 'Yes' THEN 1 ELSE 0 END) as attempt,SUM(CASE WHEN exam_given = 'No' THEN 1 ELSE 0 END) as not_attempt,SUM(score) as total_obtain_score,AVG(score) as avg_score FROM `assign_exam_to_user` au LEFT JOIN examinations de ON de.id=au.exam_id LEFT JOIN signin s ON s.id = au.assigned_user_id WHERE MONTH(de.created_on) = ? AND YEAR(NOW()) $ops_cond GROUP BY au.assigned_user_id ORDER BY score_percent DESC";

		$query = $this->db->query($sql,array($month));
        $data =  $query->result_array();

		echo json_encode(array('data'=>$data));

	}

	/**
	 *===========================
	 * Created By: SOURAV SARKAR
	 * Created On: 23-Aug-2022
	 *===========================
	 *  
	 **/

	public function get_agent_pkt_details(){

		$month = $this->input->post('selectedMonth');
		$agentId = $this->input->post('agentId');

		$sql="SELECT au.id,au.assigned_user_id,concat(s.fname, ' ',s.lname) as name,s.xpoid,s.fusion_id,(SELECT concat(ss.fname,' ',ss.lname) FROM signin ss WHERE ss.id=s.assigned_to) as tl_name,au.score,de.total_score,ROUND(((au.score/de.total_score)*100),2) as score_percent,(CASE WHEN exam_given = 'Yes' THEN 'Attempt' ELSE 'Not Attempt' END) as action_taken,date(e.created_on) as exam_given_on,de.exam_name FROM `assign_exam_to_user` au LEFT JOIN examinations de ON de.id=au.exam_id LEFT JOIN signin s ON s.id = au.assigned_user_id LEFT JOIN pkt_exam_given e ON au.exam_id = e.exam_id WHERE MONTH(de.created_on) = ? AND YEAR(NOW()) AND au.assigned_user_id = ? GROUP BY au.id";

		$query = $this->db->query($sql,array($month,$agentId));
        $data =  $query->result_array();

		echo json_encode(array('data'=>$data));

	}

	/**
	 *===========================
	 * Created By: SOURAV SARKAR
	 * Created On: 23-Aug-2022
	 *===========================
	 *  
	 **/
	
	public function get_overall_monthly_data(){

		$month = $this->input->post('selectedMonth');

		$current_user = get_user_id();
		$ops_cond="";
		if(get_global_access()!=1){
		    if(get_role_dir()=='manager' && get_dept_folder()=='operations'){

		        $ops_cond=" AND (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";

		    }else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){

		        $ops_cond=" AND assigned_to='$current_user'";

		    }else if(get_role_dir()=='agent' && get_dept_folder()=='qa'){

		        $ops_cond=" AND assigned_qa ='$current_user'";

		    }else if(get_role_dir()=='agent' && get_dept_folder()=='operations'){

		        $ops_cond=" AND agent_id='$current_user'";
		        
		    }else{
		        $ops_cond="";
		    }
		}

		$sql = "SELECT SUM(CASE WHEN au.exam_given = 'Yes' THEN 1 ELSE 0 END) as attempt,SUM(CASE WHEN au.exam_given = 'No' THEN 1 ELSE 0 END) as not_attempt,SUM(IF(exam_given = 'Yes', (CASE WHEN ROUND(((au.score/ de.total_score)*100),2) >= 85 THEN 1 ELSE 0 END), 0)) as pass_count,SUM(IF(exam_given = 'Yes', (CASE WHEN ROUND(((au.score/ de.total_score)*100),2) < 85 THEN 1 ELSE 0 END), 0)) as fail_count  FROM `assign_exam_to_user` au LEFT JOIN examinations de ON de.id=au.exam_id LEFT JOIN signin s ON s.id = au.assigned_user_id WHERE MONTH(de.created_on) = ? AND YEAR(NOW()) $ops_cond";

		$query = $this->db->query($sql,array($month));
		$data = $query->row_array();

		$labels = array('Attempt','Not Attempt','Pass Count','Fail Count');
		$chartValue = array($data['attempt'],$data['not_attempt'],$data['pass_count'],$data['fail_count']);
		echo json_encode(array('labels'=>$labels,'data'=>array_filter($chartValue)));
	}

	public function create_exam(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			if(get_global_access()!=1 && get_role_dir()!='trainer'){
				redirect('process_knowledge_test/my_exam');
			}
		
			$data["aside_template"] = "qa_boomsourcing_aside/aside.php";
			$data["content_template"] = "process_knowledge_test/create_exam.php";
			$data["content_js"] = "process_knowledge_test_js.php";
			$data['message'] = "";
			/* Logic start */
			/* $sqlExaminationType = "SELECT id, examination_type_name from examination_types WHERE status=1";
			$data['examination_type_list'] = $this->Common_model->get_query_result_array($sqlExaminationType); */
			
			$sqlQuestionType = "SELECT id, question_type_name from question_types WHERE status=1";
			$data['question_type_list'] = $this->Common_model->get_query_result_array($sqlQuestionType);
			//print_r($_POST);
			// Insert operation
			if($this->input->post('submit'))
            {
				//echo "ok ---1";
				//exit;
				
				$exam_name = trim($this->input->post('exam_name'));
               // $examination_type_id = $this->input->post('examination_type_id');
                $examination_duration = $this->input->post('examination_duration');
				$question_type_id = $this->input->post('question_type_id'); 
				$monthly_start_date = $this->input->post('monthly_start_date'); 
                $monthly_end_date = $this->input->post('monthly_end_date'); 
				$total_score = $this->input->post('total_score');
				$created_on = date('Y-m-d h:i:s');
				$modified_on = date('Y-m-d h:i:s');
				$created_by=$current_user;
				$status=1;
				
				
				$_field_array = array(
					"exam_name" => $exam_name,
					"examination_duration" => $examination_duration,
					"question_type_id" => $question_type_id,
					"monthly_start_date" => $monthly_start_date,
					"monthly_end_date" => $monthly_end_date,
					"total_score" => $total_score,
					"created_on" => $created_on,
					"modified_on" => $modified_on,
					"created_by" => $created_by,
					"status" => $status
				);
				$rowid = $this->db->insert('examinations', $_field_array);
				$last_inserted_id = $this->db->insert_id();
				
				// Create directory 
				mkdir('./uploads/exams/'.$last_inserted_id, 0777, true);
				
				if(!empty($rowid)){
					$data['message'] = "Record created successfully!!!";
				}
				//exit;
				
				//redirect('process_knowledge_test/create_exam/');
			}
			/* Logic ends*/
			$this->load->view("dashboard",$data);
		}
	}
	// Checking duplicate exam name
	public function duplicate_examname(){
		if(check_logged_in())
		{
			$exam_name = $_POST['exam_name'];
			$sql = "SELECT * FROM examinations WHERE exam_name='".$exam_name."' AND status='1'";
			$query = $this->db->query($sql);
			$data = $query->row_array();
			//print_r($data);
			if($data){
				$response = array('error'=>'true');
					
			}else{
				$response = array('error'=>'false');
			}
			echo json_encode($response);
		}
	}
	// Checking duplicate set name
	public function duplicate_setname()
	{
		if(check_logged_in())
		{
			$set_name = $_POST['set_name'];
			$exam_id = $_POST['exam_id'];
			//echo $set_name." ".$exam_id;
			$sql = "SELECT * FROM question_sets WHERE exam_id=".$exam_id." AND set_name='".$set_name."' AND status='1'";
			$query = $this->db->query($sql);
			$data = $query->row_array();
			//print_r($data);
			if($data){
				$response = array('error'=>'true');
					
			}else{
				$response = array('error'=>'false');
			}
			echo json_encode($response);
		}
	}
	// Checking duplicate names function end
	public function exam_list(){
		if(check_logged_in())
		{
			
			
			$current_user = get_user_id();
			$data["aside_template"] = "qa_boomsourcing_aside/aside.php";
			$data["content_template"] = "process_knowledge_test/exam_list.php";
			$data["content_js"] = "process_knowledge_test_js.php";
			/*Logic Starts*/
			/* dropdown */
			//$sqlExaminationType = "SELECT id, examination_type_name from examination_types WHERE status=1";
			//$data['examination_type_list'] = $this->Common_model->get_query_result_array($sqlExaminationType);
			
			$sqlQuestionType = "SELECT id, question_type_name from question_types WHERE status=1";
			$data['question_type_list'] = $this->Common_model->get_query_result_array($sqlQuestionType);
			/* dropdown */
			$data['examination_list']="";
			$data['question_type_id'] = "";
			$data['type_id'] = "";
			if($this->input->get('submit'))
            {
				$type_id = $this->input->get('examination_type');
				$question_type_id = $this->input->get('question_type');
				$sqlExaminationList = "SELECT examinations.id, examinations.exam_name, examinations.examination_duration, examinations.created_on,   		ques_type.question_type_name  
								   FROM examinations 
								   LEFT JOIN question_types ques_type
								   ON examinations.question_type_id = ques_type.id 
								   WHERE examinations.status=1 AND ques_type.id=$question_type_id";
								   
				$data['examination_list'] = $this->Common_model->get_query_result_array($sqlExaminationList);
				$data['question_type_id'] = $question_type_id;
				$data['type_id'] = $type_id;
			}
			
			
			/*Logic Ends*/
			$this->load->view("dashboard",$data);
		}
	}
	public function upload_question_set($exam_id,$action){
		$this->load->library('upload');
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa_boomsourcing_aside/aside.php";
			$data["content_template"] = "process_knowledge_test/upload_question_set.php";
			$data["content_js"] = "process_knowledge_test_js.php";
			
			/*Logic starts*/
			$data['exam_id'] = $exam_id;
			$data['action'] = $action;
			
			
			$sqlQuestionType = "SELECT id, question_type_name from question_types WHERE status=1";
			$data['question_type_list'] = $this->Common_model->get_query_result_array($sqlQuestionType);
			
			$sqlQuestion = "Select * FROM examinations WHERE id =$exam_id";
			$data['exam_info'] = $this->Common_model->get_query_result_array($sqlQuestion);
			
			if($this->input->post('submit'))
            {
				if($this->input->post('action')==$action){
					
					$set_name = trim($this->input->post('set_name'));
					$exam_id = $this->input->post('exam_id');
					$question_type_id = $this->input->post('question_type_id');
					$created_on = date('Y-m-d h:i:s');
					$modified_on = date('Y-m-d h:i:s');
					$created_by=$current_user;
					$status=1;
					
					$_field_array = array(
						"set_name" => $set_name,
						"exam_id" => $exam_id,
						"question_type_id" => $question_type_id,
						"created_on" => $created_on,
						"modified_on" => $modified_on,
						"created_by" => $created_by,
						"status" => $status
					);
					//print_r($_field_array);
					//exit;
					$response['insert'] = $this->db->insert('question_sets', $_field_array);
					$last_inserted_id = $this->db->insert_id();
					
					
					$config['upload_path']          = './uploads/exams_pkt/'.$exam_id;
					//$config['allowed_types']        = 'xlsx';
					$config['allowed_types']        = array('xlsx','csv');
					$config['max_size']             = 90000;
					$this->upload->initialize($config);
					$this->upload->overwrite = true;
					if(!empty($_FILES['set_file_name']['name'])){
						if(!$this->upload->do_upload('set_file_name'))
						{
							$response['stat'] = false;
							$response['datas'] = $this->upload->display_errors();
							$data['message'] = $response['datas'];
							//echo $response['datas'];
							//exit;
						}else{
							//$datas = $this->upload->data();
							$csv_file_name = 'set_file_name';
							if ($_FILES['set_file_name']['name']) {
								
								//$outputFile = 'uploads/exams/'.$exam_id;
								//echo base_url().$outputFile;
								//exit;
								
								$fname = time().'_examination'.$exam_id."_set".$last_inserted_id;
								$configCsv = [
									'upload_path'   => './uploads/exams_pkt/'.$exam_id,
									//'allowed_types' => 'xlsx',
									'allowed_types' => array('xlsx','csv'),
									'max_size' => 90000 ,
									'file_name'=>$fname
								];
								$csv_name = $this->upload_user_file($configCsv,$csv_file_name);
								
								if(!empty($csv_name)){
									$response['upload']=1;
									$fileName = array(
											'set_file_name' => $csv_name
									);

									$this->db->where('id', $last_inserted_id);
									$response['update'] = $this->db->update('question_sets', $fileName);
								}
								/* Read the excel file and insert into the question table */
								$file_name = './uploads/exams_pkt/'.$exam_id.'/'.$csv_name;
								$uploadData = $this->upload_set_question($file_name,$exam_id,$last_inserted_id);
								//print_r($uploadData);
								//exit;
								if($uploadData == true){
									$response['question_insert'] = 1;
								}else{
									$response['question_insert'] = 0;
								}
								
								
								/* end of code */
								
								
							}
							
						}
					}
					//print_r($_FILES);
					
					//exit;
					if($response['insert'] == 1 && $response['upload']==1 && $response['update']==1 && $response['question_insert'] == 1){
						$data['message'] = "Exam set uploaded successfully!!!";
					}else if(!empty($response['upload_res'])){
						$data['message'] = $response['upload_res'];
					}else if($response['question_insert'] == 0){
						$data['message'] ="Failed!! Please upload question set containing at least 5 and maximum 25 questions";
					}
				}
			}
			
			/*Logic ends*/
			
			
			$this->load->view("dashboard",$data);
		}
	}
	public function view_question_list($set_id){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa_boomsourcing_aside/aside.php";
			$data["content_template"] = "process_knowledge_test/view_question_list.php";
			$data["content_js"] = "process_knowledge_test_js.php";
			
			$sql = "SELECT q.question,e.exam_name, s.set_name, q.created_on FROM pkt_questions q  
			LEFT JOIN question_sets s ON s.id=q.set_id 
			LEFT JOIN examinations e ON e.id = q.exam_id
			WHERE q.set_id = $set_id";
			$data['question_list'] = $this->Common_model->get_query_result_array($sql);
			/* echo "<pre>";
			print_r($data['question_list']);
			echo "</pre>"; */
			$this->load->view("dashboard",$data);
		}
	}
	function upload_set_question($fileName,$exam_id,$set_id)
	{
		//echo $fileName;
		//exit;
		if(check_logged_in())
		{
		$current_user = get_user_id();
		$csvRelation = [
			"question" => '0',
			"option1" => '1',
			"option2" => '2',
			"option3" => '3',
			"option4" => '4',
			"correct_answer" => '5'
		 ];
		 
		$csvData = array();
		$headerData = array();
		$handle = fopen($fileName, "r");
		$counter=0;
		 
		
		//exit;
		while (($result = fgetcsv($handle)) !== false)
		 {
			$counter++;
			if($counter == 1){
				$headerData = $result;
			} else {
				$csvData[] = array_map('trim', $result);
			}
		}
		 //$this->db->trans_begin();
		$tot_questions = count($csvData);
		 if($tot_questions < 5){
			 $this->db->where('id', $set_id);
			 $this->db->delete('question_sets');
			 unlink($fileName);
			 return false;
		 }
		 if($tot_questions > 25){
			 
			 $this->db->where('id', $set_id);
			 $this->db->delete('question_sets');
			 unlink($fileName);
			 return false;
		 }
		 //exit;
		foreach($csvData as $dataRow)
		 {
			$question = $dataRow[$csvRelation['question']];
			$option1 = $dataRow[$csvRelation['option1']];
			$option2 = $dataRow[$csvRelation['option2']];
			$option3 = $dataRow[$csvRelation['option3']];
			$option4 = $dataRow[$csvRelation['option4']];
			$correct_answer = $dataRow[$csvRelation['correct_answer']];
			$created_on = date('Y-m-d h:i:s');
			$modified_on = date('Y-m-d h:i:s');
			
			$ins_value = array(
				"exam_id"=>$exam_id,
				"set_id"=>$set_id,
				"question"=>$question,
				"option1"=>$option1,
				"option2"=>$option2,
				"option3"=>$option3,
				"option4"=>$option4,
				"correct_answer"=>$correct_answer,
				"created_on"=>$created_on,
				"modified_on"=>$modified_on,
				"status"=>1,
				"created_by"=>$current_user
			);
			$rowId=$this->db->insert('pkt_questions', $ins_value);
			
		 }
		
		 return true;
		}
	}
	private function upload_user_file($config,$filename){
		
		$this->upload->initialize($config);
		$this->upload->overwrite = true;
		if ($this->upload->do_upload($filename))
		{   
			$data = $this->upload->data();
			
			return $data['file_name'];
		}else{
			return false;

		}

	}
	public function view_exams($exam_id,$action){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa_boomsourcing_aside/aside.php";
			$data["content_template"] = "process_knowledge_test/view_exams.php";
			$data["content_js"] = "process_knowledge_test_js.php";
			
			$sqlExamination = "SELECT id, exam_name from examinations WHERE id=$exam_id";
			$query = $this->db->query($sqlExamination);
			$data['examination'] = $query->row_array();
			
			$sqlExaminationSet = "SELECT * from question_sets WHERE exam_id=$exam_id";
			$data['question_set_list'] = $this->Common_model->get_query_result_array($sqlExaminationSet);
			
			
			$this->load->view("dashboard",$data);
		}
	}
	public function exam_set_download($setId){
	  if(check_logged_in()){ 
		$sqlSet = "SELECT * from question_sets WHERE id=$setId";
		$query = $this->db->query($sqlSet);
		$data = $query->row_array();
		$file_name =FCPATH."uploads/exams_pkt/".$data['exam_id']."/".$data['set_file_name'];
		ob_end_clean();
		header('Content-Description: File Transfer');
		header('Content-Type: application/csv');
		header('Content-Disposition: attachment; filename='.basename($file_name));
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . filesize($file_name));
		readfile($file_name);
		exit();
		/*$contenttype = "application/force-download";
		header("Content-Type: " . $contenttype);
		header("Content-Disposition: attachment; filename=\"" . basename($file_name) . "\";");
		readfile("your file uploaded path".$file_name);
		exit();*/
		
	  }
   }
   public function sample_download(){
	  if(check_logged_in()){ 
		//$file_name = FCPATH."uploads/sample_question_paper.csv";
		$file_name = FCPATH."uploads/exams_pkt/sample_question_paper.csv";
		ob_end_clean();
		header('Content-Description: File Transfer');
		header('Content-Type: application/csv');
		header('Content-Disposition: attachment; filename='.basename($file_name));
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . filesize($file_name));
		readfile($file_name);
		exit();
	  }
   }
   public function assign_exam_to_user(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa_boomsourcing_aside/aside.php";
			$data["content_template"] = "process_knowledge_test/assign_exam_to_user.php";
			$data["content_js"] = "process_knowledge_test_js.php";
			
			/*Code logic starts*/
			// Location dropdown
			$sqlLocation = "SELECT abbr, location from office_location WHERE is_active=1";
			$data['location'] = $this->Common_model->get_query_result_array($sqlLocation);
			
			//Department Dropdown
			$sqlDepartment = "SELECT id, description from department WHERE is_active=1";
			$data['department'] = $this->Common_model->get_query_result_array($sqlDepartment);
			
			//Exams Dropdown
			$sqlExam = "SELECT id, exam_name FROM examinations WHERE status=1";
			$data['exams'] = $this->Common_model->get_query_result_array($sqlExam);
			
			//Client Dropdown
			$sqlClient = "SELECT id, fullname FROM client WHERE is_active=1 and id=275";
			$data['client'] = $this->Common_model->get_query_result_array($sqlClient);
			
			
			// Assign exams to users
			if($this->input->post('submit')){
				
				
				$client_id = $this->input->post('clients');
				
				$department = $this->input->post('department');
				$location = ltrim($this->input->post('locationArr'));
				$locArr = explode(",",$location);
				$gotLocation = implode("','", $locArr);
				
				
				if(empty($this->input->post('supervisorArr')) && empty($this->input->post('agentArr'))){
					$sqlSupervisor = "SELECT id FROM signin WHERE is_assign_client(id,$client_id) AND status=1 AND dept_id=$department AND office_id IN ('".$gotLocation."') AND role_id IN  (SELECT id FROM role WHERE folder IN ('tl','manager'))";
					$supervisors = $this->Common_model->get_query_result_array($sqlSupervisor);
					foreach($supervisors as $sup){
						$assigned_super_arr[]=$sup['id'];
					}
					$gotSupervisor = implode("','", $assigned_super_arr);
					$sqlAgent = "SELECT id FROM signin WHERE status=1 AND assigned_to IN ('".$gotSupervisor."')";
					$Agents = $this->Common_model->get_query_result_array($sqlAgent);
					$assigned_agent_arr =array();
					if(!empty($Agents)){
						foreach($Agents as $a){
							$assigned_agent_arr[]=$a['id'];
						}
					}
					
					$assigned_users_arr = array_merge($assigned_super_arr,$assigned_agent_arr);
					
				}else{
					$assigned_superviors = ltrim($this->input->post('supervisorArr'),',');
					$assigned_agents = ltrim($this->input->post('agentArr'),',');
					$assigned_users_str = $assigned_superviors.",".$assigned_agents;
					$assigned_users_arr = explode(',',$assigned_users_str);
				}
				
				
				$exam_id = $this->input->post('exams');
				$set_id = $this->input->post('sets');
				$question_assigned_type = $this->input->post('assign_type');
				$created_on = date('Y-m-d h:i:s');
				$modified_on = date('Y-m-d h:i:s');
				$created_by = get_user_id();
				$no_of_questions = $this->input->post('no_of_questions');
				
				if($question_assigned_type == 'random'){
					$sql_question = "SELECT id FROM pkt_questions WHERE exam_id=$exam_id ORDER BY RAND() LIMIT $no_of_questions";
					$questions = $this->Common_model->get_query_result_array($sql_question);
					foreach($questions as $question){
						$set_id = $set_id.",".$question['id'];
					}
				}
				//echo $sql_question;
				//echo "<br>";
				
				
				foreach($assigned_users_arr as $assigned_user_id){
					if(!empty($assigned_user_id)){
						$field_arr = array(
							"client_id"=>$client_id,
							"assigned_user_id"=>$assigned_user_id,
							"exam_id"=>$exam_id,
							"set_id"=>$set_id,
							"question_assigned_type"=>$question_assigned_type,
							"modified_on"=>$modified_on,
							"created_on"=>$created_on,
							"created_by"=>$created_by,
							"status"=>1,
							);
						$this->db->insert('assign_exam_to_user', $field_arr);
					}
				}
				
					$data['message'] = "Assigned Exam Successfully!!!";
				
				
			}
			/*Code logic ends*/
			$this->load->view("dashboard",$data);
		}
	}
	public function get_supervisor(){
		if(check_logged_in())
		{
			$location = $_POST['location'];
			$department = $_POST['department'];
			$client = $_POST['client'];
			//exit;
			$location = ltrim($location,",");
			$arrLocation = explode(",",$location);
			$gotLocation = implode("','", $arrLocation);
			
			// Selcting the Supervisors where the role is tl and manager
			$sqlSupervisor = "SELECT id, fname,lname, fusion_id FROM signin WHERE is_assign_client(id,'$client') AND status=1 AND dept_id=$department AND office_id IN ('".$gotLocation."') AND role_id IN  (SELECT id FROM role WHERE folder IN ('tl','manager'))";
			//echo $sqlSupervisor;
			//exit;
			$supervisors = $this->Common_model->get_query_result_array($sqlSupervisor);
			//$output = '<option value="">Select Supervisor</option>';
			foreach($supervisors as $supervisor){
				$output .= '<option value="'.$supervisor['id'].'">'.$supervisor['fname'].' '.$supervisor['lname'].'</option>';
			}
			echo $output;
			
		}
	}
	public function get_agent(){
		if(check_logged_in())
		{
			$supervisor = $_POST['supervisor'];

			if(isset($supervisor) && !empty($supervisor)){
				$supervisor = ltrim($supervisor,",");
				$arrSupervisor = explode(",",$supervisor);
				$gotSupervisor = implode("','", $arrSupervisor);
				
				//Supervisor Dropdown
				//$sqlAgent = "SELECT id, fname,lname, fusion_id FROM signin WHERE status=1 AND assigned_to IN ('".$gotSupervisor."') AND role_id IN (SELECT id FROM role WHERE folder='agent')";
				$sqlAgent = "SELECT id, fname,lname, fusion_id FROM signin WHERE status=1 AND assigned_to IN ('".$gotSupervisor."')";
				//echo $sqlAgent;
				$agents = $this->Common_model->get_query_result_array($sqlAgent);
				
				//$output = '';
				foreach($agents as $agent){
					$output .= '<option value="'.$agent['id'].'">'.$agent['fname'].' '.$agent['lname'].'</option>';
				}
				//$response=array('supervisor'=>$output);
				//echo $sqlAgent;
				if(!empty($output)){
					echo $output;
				}
			}
		}
	}
	public function get_sets(){
		if(check_logged_in())
		{
			//echo $_POST['exams'];
			$exam_id = $_POST['exams'];
			$sqlSets = "SELECT id, set_name FROM question_sets WHERE status=1 AND exam_id=$exam_id";
			$sets = $this->Common_model->get_query_result_array($sqlSets);
				$output .= '<option value="">Select Exam Set</option>';
			foreach($sets as $set){
				$output .= '<option value="'.$set['id'].'">'.$set['set_name'].'</option>';
			}
			echo $output;
		}
	}
	public function assign_exam(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "process_knowledge_test/aside.php";
			$data["content_template"] = "process_knowledge_test/assign_exam.php";
			$data["content_js"] = "process_knowledge_test_js.php";
			
			$this->load->view("dashboard",$data);
		}
	}
	
	public function exam_result(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "process_knowledge_test/aside.php";
			$data["content_template"] = "process_knowledge_test/exam_result.php";
			$data["content_js"] = "process_knowledge_test_js.php";
			
			$this->load->view("dashboard",$data);
		}
	}
	
	public function pkt_report(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa_boomsourcing_aside/aside.php";
			$data["content_template"] = "process_knowledge_test/pkt_report.php";
			$data["content_js"] = "process_knowledge_test_js.php";
			
			
			$from_date = date('Y-m-d');
			$to_date = date('Y-m-d');
			$pkt_type="";
			$data['details'] = array();
			if($this->input->get('submit')){
				
				$from_date = $this->input->get('from_date');
				$to_date = $this->input->get('to_date');
				//$pkt_type = $this->input->get('pkt_type');
				if(get_global_access()==1){
					$userCondi="";
				}else{
					$userCondi=" AND au.assigned_user_id=$current_user";
				}
				
				$sqlQuestions="SELECT concat(s.fname, ' ',s.lname) as name,s.xpoid,s.fusion_id,de.exam_name, de.total_score , au.exam_id as exam_id,au.exam_given, au.score,date(e.created_on) as exam_given_on ,
				(SELECT concat(ss.fname,' ',ss.lname) FROM signin ss WHERE ss.id=s.assigned_to) as tl_name
				 FROM assign_exam_to_user au 
			LEFT JOIN pkt_exam_given e ON au.exam_id = e.exam_id 
			LEFT JOIN pkt_questions q ON au.exam_id=q.exam_id 
			LEFT JOIN signin s ON s.id = au.assigned_user_id
			LEFT JOIN examinations de ON de.id=au.exam_id
			WHERE au.exam_given='Yes' AND date(e.created_on)>='$from_date' AND  date(e.created_on)<='$to_date' $userCondi group by au.id";
			//echo $sqlQuestions;
			//exit;
			
			$data['details'] = $this->Common_model->get_query_result_array($sqlQuestions);
			
			//print_r($data['details']);
			}
			$data['from_date'] = $from_date;
			$data['to_date'] = $to_date;
			$data['pkt_type'] = $pkt_type;
			
			$this->load->view("dashboard",$data);
		}
	}

	public function give_exam($exam_id=null){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data['assigned_user_id'] = $current_user;
			$data["aside_template"] = "process_knowledge_test/aside.php";
			$data["content_template"] = "process_knowledge_test/give_exam.php";
			$data["content_js"] = "process_knowledge_test_js.php";
			

			
			/* Logic code starts here */
			//$sql = "SELECT * FROM assign_exam_to_user WHERE exam_id=$exam_id AND (assigned_superviors LIKE '%$current_user%' OR assigned_agents LIKE '%$current_user%')";
			$sql = "SELECT * FROM assign_exam_to_user WHERE exam_id=$exam_id AND assigned_user_id=$current_user";
			
			$query = $this->db->query($sql);
			$questions = $query->row_array();
			$set_id = $questions['set_id'];
			// Get the exam duration
				$sqlDuration = "SELECT * FROM examinations WHERE id=$exam_id";
				$qryDuration = $this->db->query($sqlDuration);
				$duration =$qryDuration->row_array(); 
				$data['exam_name'] = $duration['exam_name'];
				$data['duration'] = $duration['examination_duration'];
				$data['total_score'] = $duration['total_score'];
				
				//exit;
			// Getting the questions list 
			if($questions['question_assigned_type'] == 'random'){
				$quesArray = explode(',',$questions['set_id']);
				$newArr = array_shift($quesArray);
				$quesIDs = implode("','", $quesArray);
				
			   
				$sqlQuestions="SELECT * FROM pkt_questions WHERE id IN ('$quesIDs')";
				$data['questions'] = $this->Common_model->get_query_result_array($sqlQuestions);
				$tot = $this->Common_model->get_total('pkt_questions',"WHERE id IN ('$quesIDs')");
				$data['tot_ques'] = $tot;
				$data['each_question_marks'] = $data['total_score']/$tot;
				//echo $data['each_question_marks'];
				//exit;	
			}if($questions['question_assigned_type'] == 'set'){
				$sqlQuestions="SELECT * FROM pkt_questions WHERE set_id =$set_id AND exam_id=$exam_id";
				
				$data['questions'] = $this->Common_model->get_query_result_array($sqlQuestions);
				$tot = $this->Common_model->get_total('pkt_questions',"WHERE set_id =$set_id AND exam_id=$exam_id");
				$data['tot_ques'] = $tot;
				$data['each_question_marks'] = $data['total_score']/$tot;
				//echo $data['each_question_marks'];
				//exit;
			}
			
			/*After submit data insert answers to the table pkt_exam_given */
			if($this->input->post('submit')){
				
				$dataArr=$this->input->post('data');
				$tot_marks = 0;
				
				foreach($dataArr as $data){
					
					$exam_id= $data['exam_id'];
					$question_id= $data['question_id'];
					$assigned_user_id= $data['assigned_user_id'];
					$option = $data['option'];
					if(trim($data['option']) == "correct"){
						$tot_marks = $tot_marks + $data['individual_marks'];
					}
					$created_on = date('Y-m-d h:i:s');
				    $modified_on = date('Y-m-d h:i:s');
					
					$ins_arr = array(
						"exam_id"=>$exam_id,
						"question_id"=>$question_id,
						"exam_given_by"=>$assigned_user_id,
						"option_correct_incorrect"=>$option,
						"created_on"=>$created_on,
						"modified_on"=>$modified_on,
						"status"=>1,
						);
						$rowId=$this->db->insert('pkt_exam_given', $ins_arr);
				}
				//Update assign_exam_to_user when exam given
				$up_arr = array('exam_given'=>'Yes',
								'score'=>$tot_marks);
				
				$multipleWhere = array('exam_id' => $exam_id, 'assigned_user_id' => $assigned_user_id );
				// End of update assign_exam_to_user
				$this->db->where($multipleWhere);
				$expired = $this->db->update('assign_exam_to_user', $up_arr);
				// Update ends here
				redirect(base_url()."process_knowledge_test/my_exam");
			}
			/* end */
			
			/* Logic code ends here */
			
			$this->load->view("dashboard",$data);
		}
	}
	/* Checking the correct answer */
	public function get_correct_answer(){
		if(check_logged_in())
		{
			$option = $_POST['option'];
			$question_id = $_POST['question_id'];
			
			$correct_option= explode('_',$option);
			$sql = "SELECT * FROM pkt_questions WHERE id=$question_id";
			$query = $this->db->query($sql);
			$questions = $query->row_array();
			//print_r($questions);
			if($questions['correct_answer'] == $correct_option[0]){
				$response['answer']="correct";
				$response['question_id']=$question_id;
			}else{
				$response['answer']="incorrect";
				$response['question_id']=$question_id;
			}
			//print_r($response);
			echo $response['answer'].":".$response['question_id'];
			//echo $sqlSupervisor;
		}
	}
	/* End */
	/*Expired Exam Code start */
	public function exam_expired(){
		if(check_logged_in())
		{
			$exam_id = $_POST['exam_id'];
			$assigned_user_id = $_POST['assigned_user_id'];
			$up_arr = array('status'=>'0');
			$multipleWhere = array('exam_id' => $exam_id, 'assigned_user_id' => $assigned_user_id );
			$this->db->where($multipleWhere);
			$expired = $this->db->update('assign_exam_to_user', $up_arr);
			if($expired){
				echo "Exam Expired";
			}
		}
	}
	/* END */
	/*Re-assigned exam */
	
	public function reassign_exam(){
		if(check_logged_in())
		{
			$exam_id = $_POST['exam_id'];
			$assigned_user_id = $_POST['assigned_user_id'];
			$up_arr = array('status'=>'1');
			$multipleWhere = array('exam_id' => $exam_id, 'assigned_user_id' => $assigned_user_id );
			$this->db->where($multipleWhere);
			$reassign = $this->db->update('assign_exam_to_user', $up_arr);
			if($reassign){
				echo "Exam Re-assigned";
			}
		}
	}
	/* End */
	public function my_exam(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa_boomsourcing_aside/aside.php";
			$data["content_template"] = "process_knowledge_test/my_exam.php";
			$data["content_js"] = "process_knowledge_test_js.php";
			
			//$sql_assigned_exams = "SELECT e.exam_name,e.total_score, e.id, au.created_on, au.question_assigned_type FROM assign_exam_to_user au LEFT JOIN examinations e ON au.exam_id=e.id WHERE assigned_superviors LIKE '%$current_user%'";
			$sql_assigned_exams = "SELECT e.exam_name,e.total_score, e.id, au.created_on, au.question_assigned_type, au.status,au.score, au.exam_given FROM assign_exam_to_user au LEFT JOIN examinations e ON au.exam_id=e.id WHERE au.assigned_user_id = $current_user";
			//echo $sql_assigned_exams;
			//exit;
			$data['assigned_exams'] = $this->Common_model->get_query_result_array($sql_assigned_exams);
			$data['current_user']=$current_user;
			
			$this->load->view("dashboard",$data);
		}
	}
	// Manage assigned exams
	public function manage_assigned_exams(){
		if(check_logged_in())
				{
					$current_user = get_user_id();
					$data["aside_template"] = "qa_boomsourcing_aside/aside.php";
					$data["content_template"] = "process_knowledge_test/manage_assigned_exams.php";
					$data["content_js"] = "process_knowledge_test_js.php";
					/*Exam List start*/
					$sql_exams = "SELECT * FROM examinations WHERE status=1";
		
					$data['exam_lists'] = $this->Common_model->get_query_result_array($sql_exams);
					/*Exam list end*/
					/*User List start*/
					/*$sql_users = "SELECT signin.id, signin.fname, signin.lname FROM signin 
								 LEFT JOIN client ON signin.client_id=client.id 
								 WHERE signin.status=1 AND client.is_active=1 ORDER BY signin.fname";*/
					$sql_users = "SELECT signin.id, signin.fname, signin.lname FROM signin 
								 WHERE signin.status=1 ORDER BY signin.fname";
					//exit;
					$data['user_lists'] = $this->Common_model->get_query_result_array($sql_users);
					
					/*User list end*/
					/*Look for all the assigned list */
					/*$sql_assigned_exams = "SELECT e.exam_name,e.total_score, e.id as exam_id, au.created_on, au.question_assigned_type, au.status, au.score, au.exam_given, s.fname,s.lname,s.id as user_id
										   FROM assign_exam_to_user au 
										   LEFT JOIN examinations e ON au.exam_id=e.id 
										   LEFT JOIN signin s ON s.id = au.assigned_user_id";
										   
					//echo $sql_assigned_exams;
					//exit;
					$data['assigned_exams'] = $this->Common_model->get_query_result_array($sql_assigned_exams);*/
					$data['assigned_exams'] ="";
					/* End*/
					//print_r($data);
					if($this->input->post('submit'))
					{
						$exam_id = $this->input->post('examList');
						$user_id = $this->input->post('userList');
						$status = $this->input->post('exam_status');
						$examStr = $this->input->post('examArr');
						$userStr = $this->input->post('userArr');
						
						$exam_status = $this->input->post('exam_status');
						$extWhere="";
						if($exam_status=="exam_given" || $exam_status=="exam_pending"){
							if($exam_status=="exam_given"){
								$extWhere = "AND au.exam_given='Yes'";
							}
							if($exam_status=="exam_pending"){
								$extWhere = "AND au.exam_given='No'";
							}
							
						}else if($exam_status=="exam_expired"){
							if($exam_status=="exam_pending"){
								$extWhere = "AND e.status='0'";
							}
						}
						
						$examIDArr = explode(',',$examStr);
						$newexamArr = array_shift($examIDArr);
						$examIDs = implode("','", $examIDArr);
						
						
						$userIDArr = explode(',',$userStr);
						$newuserArr = array_shift($userIDArr);
						$userIDs = implode("','", $userIDArr);
						
						//echo $exam_id." ".$user_id." ".$status;
						$sql_assigned_exams = "SELECT e.exam_name,e.total_score, e.id as exam_id, au.created_on, au.question_assigned_type, au.status, au.score, au.exam_given, s.fname,s.lname,s.id as user_id
										   FROM assign_exam_to_user au 
										   LEFT JOIN examinations e ON au.exam_id=e.id 
										   LEFT JOIN signin s ON s.id = au.assigned_user_id
										   WHERE (au.exam_id IN('$examIDs') AND au.assigned_user_id IN('$userIDs')) $extWhere";
										   
						//echo "SQL :: ".$sql_assigned_exams;
						//exit;
						$data['assigned_exams'] = $this->Common_model->get_query_result_array($sql_assigned_exams);
						//exit;
					}
					
					$this->load->view("dashboard",$data);
				}
	}
	
 }