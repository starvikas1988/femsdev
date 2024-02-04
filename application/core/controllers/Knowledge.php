<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Knowledge extends CI_Controller {

    /////////////////////////////////////////////////////////////////////////////////////////////
    // INDEX PAGE
    /////////////////////////////////////////////////////////////////////////////////////////////
    
	 function __construct() {
		parent::__construct();
		$this->load->model('Common_model');
		$this->load->model('user_model');
	 }
	 
	public function index()
	{
		if(check_logged_in()){	
		    
			$_SESSION['pmenu'] = "1";
			
			if(get_login_type() == "client") redirect(base_url().'client_knowledge',"refresh");
			
			$data["aside_template"] = "knowledge_base/aside.php";
			$data["content_template"] = "knowledge_base/main.php";
			
			$is_global_access=get_global_access();
			$role_id        = get_role_id();
			$current_user   = get_user_id();
			$role_dir       = get_role_dir();			
			$user_office_id = get_user_office_id();
			$ses_dept_id    = get_dept_id();	
			
			$get_client_id  = get_client_ids(); 
			$get_process_id = get_process_ids(); 
			$get_user_site_id = get_user_site_id();
			
			//echo $get_client_id ."<br/>" .$get_process_id ."<br/>" .$user_office_id ."<br/>" .$role_dir ."<br/>"; die();
			
            $extra_agent_filter    = "";			
			$extra_tl_filter       = "";
			$extra_trainer_filter  = "";
			$extra_manager_filter  = "";
			$extra_office_access_filter="";
			
			if($is_global_access == 0){
			
				// AGENT FILTER
				if($role_dir == "agent")
				{
					if($get_client_id != 0){
					$extra_agent_filter  = " AND k.client_id IN ($get_client_id)";
					}
					if($get_process_id != 0){
					$extra_agent_filter .= " AND k.process_id IN ($get_process_id)";
					}
					$extra_agent_filter .= " AND k.office_id IN ('$user_office_id')";
					$extra_agent_filter .= " AND k.access_control <> 'tl'";
				}
				
				// TL FILTER
				if($role_dir == "tl")
				{
					if($get_client_id != 0){
					$extra_tl_filter  = " AND k.client_id IN ($get_client_id)";
					}
					if($get_process_id != 0){
					$extra_tl_filter .= " AND k.process_id IN ($get_process_id)";
					}
					$extra_tl_filter .= " AND k.office_id IN ('$user_office_id')";
					$extra_tl_filter .= " AND k.access_control <> 'agent'";
				}
				
				
				// MANAGER FILTER
				if($role_dir == "manager")
				{
					if($get_client_id != 0){
					$extra_manager_filter  = " AND k.client_id IN ($get_client_id)";
					}
					//$extra_manager_filter .= " AND k.process_id IN ($get_process_id)";
					$extra_manager_filter .= " AND k.access_control <> 'agent'";
				}
				
				// TRAINER FILTER
				if(get_dept_folder()=="training" || $role_dir == "admin")
				{
					$extra_agent_filter    = "";			
					$extra_tl_filter       = "";
					$extra_trainer_filter  = "";
					$extra_manager_filter  = "";
					
				}
				
				$extra_office_access_filter = " AND ( k.office_id IN (select office_id from signin where id='$current_user') OR  (select oth_office_access from signin where id='$current_user') like CONCAT('%',k.office_id,'%')) ";
				
			}
			
			// FILTER SEARCH
			$search_text = trim($this->input->get('search_text'));
			$search_office_id = trim($this->input->get('officeid'));
			$search_cat_id = trim($this->input->get('catid'));
			$extra_text = "";
			$extra_office = "";
			$extra_office_access_filter = "";
			$extra_cat = "";
			$data['s_text'] = "";
			$data['s_office'] = "";
			$data['s_cat'] = "";
			if($search_text != '')
			{
				$data['s_text'] = $search_text;
				$extra_text = " AND (k.file_name LIKE '%$search_text%' OR k.tags LIKE '%$search_text%')";
			}
			
			if($search_office_id != '')
			{
				$data['s_office'] = $search_office_id;
				$extra_office = " AND k.office_id = '$search_office_id'";
			}else{
				$data['s_office'] = $user_office_id;
				$extra_office = " AND k.office_id IN ('$user_office_id')";
				
			}
			
			if($search_cat_id != '')
			{
				$data['s_cat'] = $search_cat_id;
				$extra_cat = " AND k.category = '$search_cat_id'";
			}
			
			
			
			
			
			// SQL MAIN
			$qSql="SELECT k.*, c.shname as client_name, p.name as process_name, o.office_name as office_location FROM knowledge_base as k, client as c, process as p,office_location as o WHERE k.client_id = c.id AND k.process_id = p.id AND k.office_id = o.abbr AND k.file_type NOT IN ('video') $extra_cat $extra_office $extra_text $extra_tl_filter $extra_agent_filter $extra_trainer_filter $extra_manager_filter $extra_office_access_filter GROUP BY k.process_id";
			
			//echo  $qSql;
			
			$data["knowledge_details"] = $clientArray = $this->Common_model->get_query_result_array($qSql);
			
			
			if(($search_office_id != "") || ($user_office_id != "")) {
				if($search_office_id != ""){ $user_office_id = $search_office_id; }
				$qSql="SELECT DISTINCT(k.category) as catname FROM knowledge_base as k WHERE k.category IS NOT NULL AND k.file_type NOT IN ('video') $extra_tl_filter $extra_agent_filter $extra_office ORDER by catname ASC";
				$data["cat_array"] = $catArray = $this->Common_model->get_query_result_array($qSql);
			}
			
			
			
			//echo $qSql_office;
			if($is_global_access==1){
				// SQL OFFICE
				$qSql_office="SELECT k.office_id as office_id, o.office_name as office_name FROM knowledge_base as k, client as c, process as p,office_location as o WHERE k.client_id = c.id AND k.process_id = p.id AND k.office_id = o.abbr AND k.file_type NOT IN ('video')  GROUP BY k.office_id";
				$data["office_details"] = $clientArrayoffice = $this->Common_model->get_query_result_array($qSql_office);
			}else{
				
				$qSql_office="SELECT abbr as office_id, office_name   FROM office_location where abbr=(select office_id from signin where id='$current_user') OR (select oth_office_access from signin where id='$current_user') like CONCAT('%',abbr,'%') ORDER BY office_name";
				
				$data["office_details"] = $clientArrayoffice = $this->Common_model->get_query_result_array($qSql_office);
				
			}
		    
			//  AND client_id = '$cid' AND office_id = '$oid' 
			
			// FILE ATTACHMENTS
			$file_array[] = array();
			foreach($clientArray as $tokenarray)
			{
				$pid = $tokenarray['process_id'];
				$cid = $tokenarray['client_id'];
				$oid = $tokenarray['office_id'];
				$file_id = "SELECT id, file_name, uploaded_name, office_id, client_id, process_id  from knowledge_base as k WHERE process_id = '$pid' AND k.file_type NOT IN ('video') $extra_cat $extra_office $extra_tl_filter $extra_trainer_filter $extra_manager_filter $extra_agent_filter $extra_text";
				$fileq = $this->db->query($file_id);
				$file_array[$pid] = $fileq->result_array();
			}
			$data['all_pu_attach'] = $file_array;
		
			$this->load->view('dashboard',$data);
		}
	}
	
	
	
	public function video()
	{
		if(check_logged_in()){	
		    
			$_SESSION['pmenu'] = "2";
			
			if(get_login_type() == "client") redirect(base_url().'client_knowledge/video',"refresh");
			
			$data["aside_template"] = "knowledge_base/aside.php";
			$data["content_template"] = "knowledge_base/video.php";
			
			
			$role_id        = get_role_id();
			$current_user   = get_user_id();
			$role_dir       = get_role_dir();			
			$user_office_id = get_user_office_id();
			$ses_dept_id    = get_dept_id();	
			
			$get_client_id  = get_client_ids();
			$get_process_id = get_process_ids();
			$get_user_site_id   = get_user_site_id();
			$is_global_access=get_global_access();
			
			$extra_agent_filter    = "";			
			$extra_tl_filter       = "";
			$extra_trainer_filter  = "";
			$extra_manager_filter  = "";
			$extra_office_access_filter="";
			$extra_access_filter = "";
			
			$data['myclients'] = explode(',',$get_client_id);
			$data['myprocess'] = explode(',',$get_process_id);
			
			
			if($is_global_access == 0){
				
			// AGENT FILTER
			if($role_dir == "agent")
			{
				if($get_client_id != 0){
				$extra_agent_filter  = " AND k.client_id IN ($get_client_id)";
				}
				if(($get_process_id != 0) && ($get_process_id != 281)){
				$extra_agent_filter .= " AND k.process_id IN ($get_process_id)";
				}
				$extra_access_filter .= " AND k.access_control <> 'tl'";
			}
			
			
			// TL FILTER
			if($role_dir == "tl")
			{
				
				if($get_client_id != 0){
				$extra_tl_filter  = " AND k.client_id IN ($get_client_id)";
				}
				if($get_process_id != 0){
				$extra_tl_filter .= " AND k.process_id IN ($get_process_id)";
				}
				$extra_tl_filter .= " AND k.office_id IN ('$user_office_id')";
				$extra_access_filter .= " AND k.access_control <> 'agent'";
			}
			
			
			// MANAGER FILTER
			if($role_dir == "manager")
			{
				if($get_client_id != 0){
				$extra_manager_filter  = " AND k.client_id IN ($get_client_id)";
				}
				//$extra_manager_filter .= " AND k.process_id IN ($get_process_id)";
				$extra_access_filter .= " AND k.access_control <> 'agent'";
			}
			
			// TRAINER FILTER
			if(get_dept_folder()=="training" || $role_dir == "admin")
			{
				$extra_agent_filter    = "";			
				$extra_tl_filter       = "";
				$extra_trainer_filter  = "";
				$extra_manager_filter  = "";
				$extra_access_filter = "";
				
			}
			
			$extra_office_access_filter = " AND ( k.office_id IN (select office_id from signin where id='$current_user') OR (select oth_office_access from signin where id='$current_user') like CONCAT('%',k.office_id,'%')) ";
			
			}
			
			
			// FILTER SEARCH
			$search_text = trim($this->input->get('search_text'));
			$search_office_id = trim($this->input->get('officeid'));
			$search_cat_id = trim($this->input->get('catid'));
			$extra_text = "";
			$extra_cat = "";
			$extra_office_access_filter = "";
			$extra_office = "";
			$data['s_text'] = "";
			$data['s_office'] = "";
			$data['s_cat'] = "";
			if($search_text != '')
			{
				$data['s_text'] = $search_text;
				$extra_text = " AND (k.file_name LIKE '%$search_text%' OR k.tags LIKE '%$search_text%')";
			}
			
			if($search_office_id != '')
			{
				$data['s_office'] = $search_office_id;
				$extra_office = " AND k.office_id = '$search_office_id'";
			} else {
				$data['s_office'] = $user_office_id;
				$extra_office = " AND k.office_id IN ('$user_office_id')";
			}
			
			if($search_cat_id != '')
			{
				$data['s_cat'] = $search_cat_id;
				$extra_cat = " AND k.category = '$search_cat_id'";
			}
			
			
			
			// SQL MAIN
			$qSql="SELECT k.*, c.shname as client_name, p.name as process_name, o.office_name as office_location FROM knowledge_base as k, client as c, process as p,office_location as o WHERE k.client_id = c.id AND k.process_id = p.id AND k.office_id = o.abbr AND k.file_type = 'video' $extra_cat  $extra_office  $extra_office_access_filter GROUP BY k.process_id";
			
			$data["knowledge_details"] = $clientArray = $this->Common_model->get_query_result_array($qSql);
			
			// CATEGORY FILTER
			if(($search_office_id != "") || ($user_office_id != "")) {
				if($search_office_id != ""){ $user_office_id = $search_office_id; }
				$qSql="SELECT DISTINCT(k.category) as catname FROM knowledge_base as k WHERE k.category IS NOT NULL AND k.file_type = 'video' $extra_office ORDER by catname ASC";
				$data["cat_array"] = $catArray = $this->Common_model->get_query_result_array($qSql);
			}
			
			
			
			if($is_global_access==1){
				// SQL OFFICE
				$qSql_office="SELECT k.office_id as office_id, o.office_name as office_name FROM knowledge_base as k, client as c, process as p,office_location as o WHERE k.client_id = c.id AND k.process_id = p.id AND k.office_id = o.abbr AND k.file_type = 'video'  GROUP BY k.office_id";
				$data["office_details"] = $clientArrayoffice = $this->Common_model->get_query_result_array($qSql_office);
			}else{
				
				$qSql_office="SELECT abbr as office_id, office_name   FROM office_location where abbr=(select office_id from signin where id='$current_user') OR (select oth_office_access from signin where id='$current_user') like CONCAT('%',abbr,'%') ORDER BY office_name";
				
				$data["office_details"] = $clientArrayoffice = $this->Common_model->get_query_result_array($qSql_office);
				
			}
			
			
			// FILE ATTACHMENTS
			$file_array[] = array();
			foreach($clientArray as $tokenarray)
			{
				$pid = $tokenarray['process_id'];
				$cid = $tokenarray['client_id'];
				$oid = $tokenarray['office_id'];
				$act = $tokenarray['access_control'];
				
				$search_access_filter = $extra_access_filter;
				if($act == 'all'){ $search_access_filter = ""; }
				
				if($cid == 0){
					$file_id = "SELECT id, file_name, uploaded_name, office_id, client_id, process_id from knowledge_base as k WHERE process_id = '$pid' AND file_type = 'video' $extra_cat $extra_office $extra_text $search_access_filter";
				} else {
					if($act == 'all'){
						$file_id = "SELECT id, file_name, uploaded_name, office_id, client_id, process_id from knowledge_base as k WHERE process_id = '$pid' AND file_type = 'video' $extra_cat $extra_office $extra_text $search_access_filter";
					} else {
						$file_id = "SELECT id, file_name, uploaded_name, office_id, client_id, process_id from knowledge_base as k WHERE process_id = '$pid' AND file_type = 'video' $extra_cat $extra_office $extra_tl_filter $extra_trainer_filter $extra_manager_filter $extra_agent_filter $extra_text $search_access_filter";
					}
				}
				
				$fileq = $this->db->query($file_id);
				$file_array[$pid] = $fileq->result_array();
			}
			$data['all_pu_attach'] = $file_array;
		
			$this->load->view('dashboard',$data);
		}
	}
	
	
	
	public function entry()
	{
		if(check_logged_in()){
		
		if(get_global_access() == 1 || get_dept_folder()=="training" || isUploadKnowledgeBase()==true){
			
			$_SESSION['pmenu'] = "3";
			$role_id= get_role_id();
			$current_user = get_user_id();
			$role_dir= get_role_dir();			
			$user_office_id=get_user_office_id();
			$ses_dept_id=get_dept_id();	
			
			$get_client_id=get_client_ids();
			$get_process_id=get_process_ids();
			$user_site_id= get_user_site_id();
			$is_global_access=get_global_access();
		    $data["role_dir"]=$role_dir;
			
			$extra_client = "";
			$extra_office = "";
			$extra_process = "";
			$extra_text = "";
			
			$search_client = trim($this->input->get('s_assign_client'));
			$search_process = trim($this->input->get('s_assign_process'));
			$search_office_id = trim($this->input->get('s_assign_site'));
			$search_text = trim($this->input->get('search_text'));
			$search_error = trim($this->input->get('error'));
			$search_success = trim($this->input->get('success'));
			$data['error'] = ""; $data['success'] = "";
			if($search_error == 1){ $data['error'] = "Something Went Wrong! Please recheck your file & try again!"; }
			if($search_success == 1){ $data['success'] = "The file has been successfully uploaded!"; }
			
			$data['s_client'] = "";
			$data['s_office'] = "";
			$data['s_process'] = "";
			$data['s_text'] = "";
			
			// FILTER SEARCH
			if(($search_client != 'ALL') && ($search_client != ''))
			{
				$data['s_client'] = $search_client;
				$extra_client = " AND k.client_id = '$search_client'";
			}
			
			if(($search_office_id != 'ALL') && ($search_office_id != ''))
			{
				$data['s_office'] = $search_office_id;
				$extra_office = " AND k.office_id = '$search_office_id'";
			}
			
			if(($search_process != 'ALL') && ($search_process != '') && ($search_process != '0'))
			{
				$data['s_process'] = $search_process;
				$extra_process = " AND k.process_id = '$search_process'";
			}
			
			if($search_text != '')
			{
				$data['s_text'] = $search_text;
				$extra_text = " AND (k.file_name LIKE '%$search_text%' OR k.tags LIKE '%$search_text%')";
			}
			
			//$extra_office_access_filter = " ";
			$extra_office_access_filter = " AND ( k.office_id IN (select office_id from signin where id='$current_user') OR (select oth_office_access from signin where id='$current_user') like CONCAT('%',k.office_id,'%')) ";
			if($is_global_access==1){
				$extra_office_access_filter = " ";
			}
			
			
			// DROPDOWN DATA
			if($is_global_access==1){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			$data['client_list'] = $this->Common_model->get_client_list();
			//$data['process_list'] = $this->Common_model->get_process_list();
			
			
			// SQL CATEGORY
			$qSql="SELECT DISTINCT(category) as catname FROM knowledge_base WHERE category IS NOT NULL ORDER by catname ASC";
			$data["category_details"] = $catArray = $this->Common_model->get_query_result_array($qSql);
			
			// SQL MAIN
			$qSql="SELECT k.*, c.shname as client_name, p.name as process_name, o.office_name as office_location FROM knowledge_base as k, client as c, process as p,office_location as o WHERE k.client_id = c.id AND k.process_id = p.id AND k.office_id = o.abbr $extra_client $extra_office $extra_process $extra_text $extra_office_access_filter GROUP BY k.process_id, k.client_id, k.office_id";
			
			$data["knowledge_details"] = $clientArray = $this->Common_model->get_query_result_array($qSql);
			
			// FILE ATTACHMENTS
			$file_array[] = array();
			foreach($clientArray as $tokenarray)
			{
				$pid = $tokenarray['process_id'];
				$cid = $tokenarray['client_id'];
				$oid = $tokenarray['office_id'];
				$file_id = "SELECT id, file_name, uploaded_name, office_id, client_id, process_id from knowledge_base as k WHERE k.process_id = '$pid' AND k.client_id = '$cid' AND k.office_id = '$oid' $extra_text";
				$fileq = $this->db->query($file_id);
				$file_array[$oid][$cid][$pid] = $fileq->result_array();
			}
			$data['all_pu_attach'] = $file_array;
			
			
			$data["aside_template"] = "knowledge_base/aside.php";
			$data["content_template"] = "knowledge_base/entry.php";
		
			$this->load->view('dashboard',$data);
		} else {
			redirect('/knowledge/', 'refresh');
		}
		
		}
	}
	
	
	
	
	public function upload_zip()
    {
				
        if(check_logged_in())
        {
			
			$role_id= get_role_id();
			$current_user = get_user_id();
			$role_dir= get_role_dir();			
			$user_office_id=get_user_office_id();
			$ses_dept_id=get_dept_id();	
			$curDateTime  = CurrMySqlDate();
			
			$atpid = trim($this->input->post('atpid'));
			$assign_site = trim($this->input->post('assign_site'));
			$assign_client = trim($this->input->post('assign_client'));
			$assign_process = trim($this->input->post('assign_process'));
			$assign_tags = trim($this->input->post('assign_tags'));
			$enter_category = trim($this->input->post('enter_category'));
			$access_control = trim($this->input->post('access_control'));
			$is_download = trim($this->input->post('is_download'));
			$log=get_logs();
			
			//print_r($this->input->post());
			
			$output_dir = "webpages/knowledge_base/".$assign_site."/";
			if(!is_dir($output_dir)){ mkdir($output_dir, 0777); }
			
			$output_dir = "webpages/knowledge_base/" .$assign_site ."/" .$assign_client ."/";
			if(!is_dir($output_dir)){ mkdir($output_dir, 0777); }
			
			$output_dir = "webpages/knowledge_base/" .$assign_site ."/" .$assign_client ."/" .$assign_process ."/";
			if(!is_dir($output_dir)){ mkdir($output_dir, 0777); }
			
			$output_dir_zip = "webpages/knowledge_base/" .$assign_site ."/" .$assign_client ."/" .$assign_process ."/" ."zip/";
			if(!is_dir($output_dir_zip)){ mkdir($output_dir_zip, 0777); }
			
			$config = [
				'upload_path'   => $output_dir_zip,
				'allowed_types' => 'zip',
				'max_size' => '1024000'
			];
			
			$this->load->library('upload');
			$this->upload->initialize($config);
			
			if (!$this->upload->do_upload('userfile'))
			{
				$error = array('error' => $this->upload->display_errors());
				//echo "<pre>".print_r($error)."</pre>"; die();
				redirect('/knowledge/entry?error=1', 'refresh');
			}
			else
			{
				$upload_data = $this->upload->data();
				
				$zip_html_name = str_replace(".","-",$upload_data['file_name']);
				
				$output_zip_directory = $output_dir_zip .$zip_html_name ."/";
				if(!is_dir($output_zip_directory)){ mkdir($output_zip_directory, 0777); }
				
				$zip = new ZipArchive;
				$file = $upload_data['full_path'];
				chmod($file,0777);
				if($zip->open($file) === TRUE) {
					$zip->extractTo($output_zip_directory);
					$zip->close();
					
					$files_array = scandir($output_zip_directory, 1);
					if(strpos($files_array[0], '.htm') != ""){
					
					$zip->open($file);
					$zip->extractTo($output_dir);
					$zip->close();
					
					//rmdir($output_zip_directory);
					
					$field_array = array(
						"office_id" => $assign_site,
						"client_id" => $assign_client,
						"process_id" => $assign_process,
						"file_name" => $files_array[0],
						"uploaded_name" => $files_array[0],
						"tags" => $assign_tags,
						"ext" => "htm",
						"is_download" => $is_download,
						"category" => $enter_category,
						"access_control" => $access_control,
						"file_type" => "webpage",
						"added_by" => $current_user,
						"added_date" =>$curDateTime,
						"log" => $log
					);
					$rowid = data_inserter('knowledge_base',$field_array);
					redirect('/knowledge/entry', 'refresh');
					
					} else {
						
						redirect('/knowledge/entry?error=1', 'refresh');
					}					
					
				} else {
					
					redirect('/knowledge/entry?error=1', 'refresh');
					
				}
			}
		
			//print_r($this->input->post());
			die();
			
			
		}
   }
	
	
	
	public function upload()
    {
				
        if(check_logged_in())
        {
			
			$role_id= get_role_id();
			$current_user = get_user_id();
			$role_dir= get_role_dir();			
			$user_office_id=get_user_office_id();
			$ses_dept_id=get_dept_id();	
			$curDateTime  = CurrMySqlDate();
			
			$atpid = trim($this->input->post('atpid'));
			$assign_site = trim($this->input->post('assign_site'));
			$assign_client = trim($this->input->post('assign_client'));
			$assign_process = trim($this->input->post('assign_process'));
			$assign_tags = trim($this->input->post('assign_tags'));
			$is_download = trim($this->input->post('is_download'));
			$enter_category = trim($this->input->post('enter_category'));
			$access_control = trim($this->input->post('access_control'));
			
			$ret='done';
			$ret_msg="";
			$log=get_logs();
			$rowid=0;
			$orgFileName="";
			
			
			
			//if($atpid!=""){
			
				$output_dir = "uploads/knowledge_base/" .$assign_site ."/";
				if(!is_dir($output_dir)){ mkdir($output_dir, 0777); }
				
				$output_dir = "uploads/knowledge_base/" .$assign_site ."/" .$assign_client ."/";
				if(!is_dir($output_dir)){ mkdir($output_dir, 0777); }
				
				$output_dir = "uploads/knowledge_base/" .$assign_site ."/" .$assign_client ."/" .$assign_process ."/";
				if(!is_dir($output_dir)){ mkdir($output_dir, 0777); }
				
				
				if(!is_array($_FILES["attach"]["name"])) //single file
					{
						if($_FILES['attach']['size'] > 1173741824){
							
							$ret_msg ='File size must be less tham 10 MB';
							$ret="error";
						}else{
							
							
							$ext = pathinfo($_FILES["attach"]["name"])['extension'];
							$orgFileName = $_FILES["attach"]["name"];
							
							$document_extension = array("doc", "docx","xls", "xlsx","ppt", "pptx", "pps", "ppsx","pdf", "txt", "csv");
							$image_extension    = array("jpg", "jpeg", "png", "gif");
							$audio_extension    = array("mp3", "aac", "wav", "ogg", "wma");
							$video_extension    = array("mp4", "avi", "mov", "mkv", "mpeg4", "wmv");
							
							$filetype = "document";
						    if(in_array($ext, $document_extension)){ $filetype = "document"; }
						    if(in_array($ext, $image_extension)){ $filetype = "image"; }
						    if(in_array($ext, $audio_extension)){ $filetype = "audio"; }
						    if(in_array($ext, $video_extension)){ $filetype = "video"; }
							
							$currentfile_name = $assign_site ."_" .$assign_client ."_" .mt_rand(111,999).".".$ext;
							
							$field_array = array(
								"office_id" => $assign_site,
								"client_id" => $assign_client,
								"process_id" => $assign_process,
								"file_name" => $orgFileName,
								"uploaded_name" => $currentfile_name,
								"tags" => $assign_tags,
								"ext" => $ext,
								"is_download" => $is_download,
								"file_type" => $filetype,
								"category" => $enter_category,
								"access_control" => $access_control,
								"added_by" => $current_user,
								"added_date" =>$curDateTime,
								"log" => $log
							);
							$rowid=data_inserter('knowledge_base',$field_array);
							$uploadedfiledir = $output_dir.$currentfile_name;
							
							move_uploaded_file($_FILES["attach"]["tmp_name"], $uploadedfiledir);
							
							$ret_msg = $currentfile_name;
							$ret='done';
						}
					}
			/*}else{
				$ret_msg ='Policy ID not found';
				$ret="error";
			}*/
			
			$retArr = array();
			$retArr[0]=$ret;
			$retArr[1]=$rowid;
			$retArr[2]=$orgFileName;
			$retArr[3]=$ret_msg;
			$retArr[4]=$assign_site;
			$retArr[5]=$assign_client;
			$retArr[6]=$assign_process;
			echo json_encode($retArr);
			
		}
   }
   
   
    public function deleteAttachment(){
	  	   
		if(check_logged_in()){
			
			$atid = trim($this->input->post('atid'));
			if($atid!="")
			{
				$qSql="select uploaded_name as value from knowledge_base where id='$atid'";
				$knowledgeUpdates_id=$this->Common_model->get_single_value($qSql);
				
				$qSql="select ext as value from process_updates_attach where id='$atid'";
				$ext=$this->Common_model->get_single_value($qSql);
				
				$aFile="/uploads/knowledge_base/".$knowledgeUpdates_id;
				unlink($aFile);
				
				$this->db->where('id', $atid);
				$this->db->delete('knowledge_base'); 
				$ans="Done";
			}else $ans="fail";
			echo $ans;
		}
	}
   
   
    public function editknowledge()
	{
		$current_user = get_user_id();
		
		if(check_logged_in())
		{
						
			$edit_assign_site = trim($this->input->post('edit_assign_site'));
			$edit_assign_client = trim($this->input->post('edit_assign_client'));
			$edit_assign_process = trim($this->input->post('edit_assign_process'));
			$edit_assign_tags = trim($this->input->post('edit_assign_tags'));
			$file_downloadable = trim($this->input->post('file_downloadable'));
			$editid = trim($this->input->post('editid'));
			$enter_category = trim($this->input->post('enter_category'));
			$access_control = trim($this->input->post('edit_access_control'));
			
			if($editid!=""){
				
				$log=get_logs();
				$role_id= get_role_id();
				$current_user = get_user_id();
				$role_dir= get_role_dir();			
				$user_office_id=get_user_office_id();
				$ses_dept_id=get_dept_id();	
				$curDateTime  = CurrMySqlDate();
			    
				$file_id = "SELECT * from knowledge_base WHERE id = '$editid'";
				$fileq = $this->Common_model->get_query_result_array($file_id);
				foreach($fileq as $tokenfile)
				{
					$eassignsite = $tokenfile['office_id'];
					$eassignclient = $tokenfile['client_id'];
					$eassignprocess = $tokenfile['process_id'];
					$efile_name = $tokenfile['file_name'];
					$euploaded_name = $tokenfile['uploaded_name'];
					$efile_ext   = $tokenfile['ext'];
					$efile_type  = $tokenfile['file_type'];
				}
				
				
				$output_dir = "uploads/knowledge_base/" .$edit_assign_site ."/";
				if(!is_dir($output_dir)){ mkdir($output_dir, 0777); }
				
				$output_dir = "uploads/knowledge_base/" .$edit_assign_site ."/" .$edit_assign_client ."/";
				if(!is_dir($output_dir)){ mkdir($output_dir, 0777); }
				
				$output_dir = "uploads/knowledge_base/" .$edit_assign_site ."/" .$edit_assign_client ."/" .$edit_assign_process ."/";
				if(!is_dir($output_dir)){ mkdir($output_dir, 0777); }
				
				
				$source_dir = "uploads/knowledge_base/" .$eassignsite ."/" .$eassignclient ."/" .$eassignprocess ."/";
				$final_dir = "uploads/knowledge_base/" .$edit_assign_site ."/" .$edit_assign_client ."/" .$edit_assign_process ."/";
				
				$currentfile_name = $edit_assign_site ."_" .$edit_assign_client ."_" .mt_rand(111,999).".".$efile_ext;
				
				$source_destination = $source_dir. $euploaded_name;
				$final_destination = $final_dir. $currentfile_name;
				rename($source_destination, $final_destination);
				
				
				$field_array = array(
					"office_id" => $edit_assign_site,
					"client_id" => $edit_assign_client,
					"process_id" => $edit_assign_process,
					"file_name" => $efile_name,
					"uploaded_name" => $currentfile_name,
					"tags" => $edit_assign_tags,
					"is_download" => $file_downloadable,
					"ext" => $efile_ext,
					"file_type" => $efile_type,
					"category" => $enter_category,
					"access_control" => $access_control,
					"added_by" => $current_user,
					"added_date" => $curDateTime,
					"log" => $log
				); 
				
				$this->db->where('id', $editid);
			    $this->db->update('knowledge_base', $field_array);
				
				//$this->db->where('id', $editid);
				//$isOK  =  $this->db->update('knowledge_base', $field_array);
				
				$ans="done";
				
			} else {
				$ans="error";
			}
			
			redirect(base_url()."knowledge/edit/" . $edit_assign_site ."/" .$edit_assign_client ."/" .$edit_assign_process);
		}
	}
	
	
	
	public function edit()
	{
		if(check_logged_in()){
			
		if(get_global_access() == 1 || get_dept_folder()=="training"){
			
			$_SESSION['pmenu'] = "3";
			$role_id= get_role_id();
			$current_user = get_user_id();
			$role_dir= get_role_dir();			
			$user_office_id=get_user_office_id();
			$ses_dept_id=get_dept_id();	
			
			$get_client_id=get_client_ids();
			$get_process_id=get_process_ids();
			$user_site_id= get_user_site_id();
			$is_global_access=get_global_access();
		    $data["role_dir"]=$role_dir;
			
			$extra_client = "";
			$extra_office = "";
			$extra_process = "";
			$extra_text = "";
			
			$search_client = $this->uri->segment('4');;
			$search_process = $this->uri->segment('5');;
			$search_office_id = $this->uri->segment('3');
			
			$data['s_client'] = "";
			$data['s_office'] = "";
			$data['s_process'] = "";
			$data['s_text'] = "";
			
			$search_text = trim($this->input->get('search_text'));
			$data['s_text'] = "";
			
			// FILTER SEARCH
			if(($search_client != 'ALL') && ($search_client != ''))
			{
				$data['s_client'] = $search_client;
				$extra_client = " AND k.client_id = '$search_client'";
			}
			
			if(($search_office_id != 'ALL') && ($search_office_id != ''))
			{
				$data['s_office'] = $search_office_id;
				$extra_office = " AND k.office_id = '$search_office_id'";
			}
			
			if(($search_process != 'ALL') && ($search_process != ''))
			{
				$data['s_process'] = $search_process;
				$extra_process = " AND k.process_id = '$search_process'";
			}
			
			
			if($search_text != '')
			{
				$data['s_text'] = $search_text;
				$extra_text = " AND (k.file_name LIKE '%$search_text%' OR k.tags LIKE '%$search_text%')";
			}
			
			
			
			// DROPDOWN DATA
			if(get_role_dir()=="super" || $is_global_access==1){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			$data['client_list'] = $this->Common_model->get_client_list();
			//$data['process_list'] = $this->Common_model->get_process_list();
			
			// SQL MAIN
			$qSql="SELECT k.*, c.shname as client_name, p.name as process_name, o.office_name as office_location FROM knowledge_base as k, client as c, process as p,office_location as o WHERE k.client_id = c.id AND k.process_id = p.id AND k.office_id = o.abbr $extra_client $extra_office $extra_process $extra_text";
			$data["knowledge_details"] = $clientArray = $this->Common_model->get_query_result_array($qSql);
			
			// SQL CATEGORY
			$qSql="SELECT DISTINCT(category) as catname FROM knowledge_base WHERE category IS NOT NULL ORDER by catname ASC";
			$data["category_details"] = $catArray = $this->Common_model->get_query_result_array($qSql);
			
			
			
			// FILE ATTACHMENTS
			$file_array[] = array();
			foreach($clientArray as $tokenarray)
			{
				$pid = $tokenarray['process_id'];
				$file_id = "SELECT id, file_name, uploaded_name from knowledge_base as k WHERE process_id = '$pid'";
				$fileq = $this->db->query($file_id);
				$file_array[$pid] = $fileq->result_array();
			}
			$data['all_pu_attach'] = $file_array;
			
			
			$data["aside_template"] = "knowledge_base/aside.php";
			$data["content_template"] = "knowledge_base/editentry.php";
		
			$this->load->view('dashboard',$data);
		} else {
			redirect('/knowledge/', 'refresh');
		}
		}
	}
	
	
	public function viewdata()
	{
		if(check_logged_in()){
			
			$log            = get_logs();
			$role_id        = get_role_id();
			$current_user   = get_user_id();
			$role_dir       = get_role_dir();			
			$user_office_id = get_user_office_id();
			$ses_dept_id    = get_dept_id();	
			$curDateTime    = CurrMySqlDate();
			
			
			$file_id = trim($this->input->post('kid'));
			
			$file_sql  = "SELECT * from knowledge_base WHERE id = '$file_id'";
			$fileArray = $this->Common_model->get_query_row_array($file_sql);
			
			// ---- STORE VIEW RECORDS
			$qSql="SELECT count(*) as value from knowledge_records WHERE uid='$current_user' AND kid = '$file_id'";
			$qrecord =$this->Common_model->get_single_value($qSql);
			if($qrecord > 0)
			{
				
				$qSqlu="UPDATE knowledge_records SET vcount = vcount+1, date = '$curDateTime', log = '$log' WHERE uid = '$current_user' AND kid = '$file_id'";
				$this->db->query($qSqlu);
				
			} else {
				
				$field_array = array(
					"uid" => $current_user,
					"kid" => $file_id,
					"vcount" => '1',
					"date" => $curDateTime,
					"log" => $log
				);
				$view_count=data_inserter('knowledge_records',$field_array);
				
			}
			
			$data['fileArray'] = $fileArray;
			$this->load->view('knowledge_base/documentview',$data);
			
			
			/*
			$file_dir = base_url() ."uploads/knowledge_base/" .$fileArray['office_id'] ."/" .$fileArray['client_id'] ."/" .$fileArray['process_id'] ."/" .$fileArray['uploaded_name'];

			if($fileArray['file_type'] == 'video')
			{
				echo '<video controls><source src="'.$file_dir.'" type="video/mp4"></video>';
			}

			if($fileArray['file_type'] == 'image')
			{
				echo '<img src="'.$file_dir.'"></img>';
			}

			if($fileArray['file_type'] == 'document')
			{
				echo "Original Filename : " .$fileArray['file_name'];
				echo "<br/>Uploade Filename : " .$fileArray['uploaded_name'];
				echo "<br/> Date Uploaded : " .$fileArray['added_date'];
				
				echo "<br/><br/>";
				
				echo "<a class='btn btn-primary' href='".$file_dir."'> <i class='fa fa-download'></i> Download</a>";
				
			}
			*/
			
		
		}
	}
	
	
	public function fileviewdata()
	{
		
		$kid = $this->input->get('kid');
		
		if($kid != ""){
			
			//--- GET VIEWS
			$qview = "SELECT count(*) as viewcount, sum(vcount) as totalcount from knowledge_records WHERE kid = '$kid'";
			$qrecord = $this->Common_model->get_query_row_array($qview);
			$data['viewcount'] = $viewcount = $qrecord['viewcount'];
			$data['totalcount'] = $totalcount = $qrecord['totalcount'];
			
			echo "<i class='fa fa-eye'></i> ".$viewcount ." viewed";
			
		}
		
	}
	
	
	public function filerecord()
	{
		
		$kid = $this->input->get('kid');
		
		if($kid != ""){
			
			//--- GET VIEWS
			$qview = "SELECT k.vcount as viewcount, s.fusion_id as fusion_id, concat(s.fname,' ',s.lname) as fullname, d.d_fullname as department, r.rolename as designation, k.date as date from knowledge_records as k
			  LEFT JOIN signin as s on k.uid = s.id
			  LEFT JOIN (SELECT id as depid, description as d_fullname, shname as d_shortname from department) as d ON d.depid = s.dept_id
			  LEFT JOIN (SELECT id as cid, shname as c_shortname, fullname as c_fullname from client) as c ON c.cid = s.client_id
			  LEFT JOIN (SELECT id as pid, name as p_fullname from process) as p ON p.pid = s.process_id
			  LEFT JOIN (SELECT abbr as shortform, office_name from office_location) as o ON o.shortform = s.office_id
			  LEFT JOIN (SELECT id as lid, concat(fname, ' ', lname) as lpname from signin) as a ON a.lid = s.assigned_to
			  LEFT JOIN (SELECT id as rid, name as rolename from role) as r ON r.rid = s.role_id
			  LEFT JOIN (SELECT id as roid, name as roleorgname from role_organization) as rg ON rg.roid = s.org_role_id
			  WHERE k.kid = '$kid' ORDER by s.dept_id, rg.roid, r.rid";
			
			$data['viewdata'] = $qrecord = $this->Common_model->get_query_result_array($qview);
			$this->load->view('knowledge_base/viewcountfile',$data);
			
		}
		
	}
	
	
	
	//--- EXCEL READER -------//
	public function checkexcel()
	{
		$this->load->library('excel');
		
		$file_id = $this->uri->segment(3);
		$file_sql  = "SELECT * from knowledge_base WHERE id = '$file_id'";
		$fileArray = $this->Common_model->get_query_row_array($file_sql);
		$data['fileArray'] = $fileArray;
		$file_dir = "uploads/knowledge_base/" .$fileArray['office_id'] ."/" .$fileArray['client_id'] ."/" .$fileArray['process_id'] ."/" .$fileArray['uploaded_name'];
		
		$file_path = $file_dir;
		$inputFileType = PHPExcel_IOFactory::identify($file_path);
		echo "<title>View File - ".$fileArray['file_name'] ."</title>";
		echo "<style>body{ cursor:cell; } th,td{ border:1px solid #ccc!important; } th:focus,th:active,td:focus,td:active{ background-color:#ccc; border:2px solid #222!important; } .selectedcell{ background-color : #3297FD!important; border:2px solid #222!important; color:#ffffff!important; } td::selection{ background-color:#3297FD; color:#ffffff; } .box{ text-align: right; } .alertbox{ display: none; position: absolute; background-color:#d4e6d4; color:#333; padding: 5px 10px; font-weight: 400; border-radius: 5px; } </style>";
		
		$objReader = PHPExcel_IOFactory::createReader($inputFileType);
		$sheetno = $this->uri->segment(4);
		$objPHPExcel = $objReader->load($file_path); 
		$sheetCount = $objPHPExcel->getSheetCount();
		$worksheetname = $objPHPExcel->getSheetNames();
		$i=0;
		foreach($worksheetname as $tokenn)
		{
			$mycolor = "#f6f7f9";
			if($i == $sheetno){ $mycolor = "#d6e1f2"; }
			echo "<a style='padding:4px 10px;background-color:".$mycolor.";color:#000;text-decoration:none;border-radius:2px;' href='".base_url()."/knowledge/checkexcel/".$file_id."/".$i."'> &#128206; ".$tokenn ."</a> ";
			$i++;
		}
		echo "<br/><br/><br/>";
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'HTML');
		$objWriter->setSheetIndex($sheetno);
		header("Content-Type: text/html");
		$objWriter->save("php://output");
		
		echo "<div class='alertbox'>Selected Content Copied!</div><div style='display:block;opacity:0' id='contentselection'></div>";
		echo "<script src='".base_url()."libs/bower/jquery/dist/jquery.js'></script>";
		echo $checkscript = <<<SCR
		<script>
		$('td').on("click", function (evt){
			if (evt.ctrlKey){
				$(this).toggleClass("selectedcell");
		     }
			 else if (evt.shiftKey){
				$(this).toggleClass("selectedcell");
				f_td = $('.selectedcell').first().index();
				f_tr = $('.selectedcell').parent('tr').first().index();
				l_td = $('.selectedcell').last().index();
				l_tr = $('.selectedcell').parent('tr').last().index();				
				for(i=f_tr;i<=l_tr;i++){
				   totaltd = $('tr:eq('+i+') td').length;
				   for(j=0;j<=totaltd;j++){
					 if(((i==f_tr) && (j<f_td)) || ((i==l_tr) && (j>l_td))){ }
					 else { $('tr:eq('+i+') td:eq('+j+')').addClass('selectedcell'); }
				   }
				}
		     }
			 else {
				$('td').removeClass('selectedcell');
				$(this).addClass('selectedcell');
			 }

			mycontent = "";
			// GET ALL SELECTED CONTENT
			$('.selectedcell').each(function(){
				mycontent += $(this).html();
				mycontent += "&nbsp;&nbsp;";
			});
			
			$('#contentselection').html(mycontent);
			const referenceNode = document.getElementById('contentselection');
			var range = document.createRange();
			range.selectNodeContents(referenceNode);  
			var sel = window.getSelection(); 
			sel.removeAllRanges(); 
			sel.addRange(range);
			document.execCommand('copy');
			$(".alertbox").css({
				top: evt.pageY,
				left: evt.pageX
			}).toggle();
			$('.alertbox').show();
			$('.alertbox').delay(600).fadeOut();
		});
		</script>
SCR;
		
	}
	
	
	//------- WORD READER ------//
	public function checkword()
	{
		$this->load->library('word');
		
		$file_id = $this->uri->segment(3);
		$file_sql  = "SELECT * from knowledge_base WHERE id = '$file_id'";
		$fileArray = $this->Common_model->get_query_row_array($file_sql);
		$data['fileArray'] = $fileArray;
		$file_dir = "uploads/knowledge_base/" .$fileArray['office_id'] ."/" .$fileArray['client_id'] ."/" .$fileArray['process_id'] ."/" .$fileArray['uploaded_name'];
		
		$file_path = $file_dir;
		$phpWord = PHPWord_IOFactory::load($file_path);
		echo "<title>View File - ".$fileArray['file_name'] ."</title>";
		$objWriter = PHPWord_IOFactory::createWriter($phpWord, 'HTML');
		header("Content-Type: text/html");
		$objWriter->save('php://output');
				
	}
	
	
	
	
	
   
	
}