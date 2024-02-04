<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Qa_servicerequest extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		
		$this->load->helper(array('form', 'url'));
        $this->load->model('Common_model');
		$this->load->model('QA_Servicerequest_model');
		$this->load->library('excel');
		
		$this->objPHPExcel = new PHPExcel();
	}
	
	private function findexts($filename){
		$filename = strtolower($filename) ;
		$exts = explode(".", $filename) ;
		$n = count($exts)-1;
		$exts = $exts[$n];
		return $exts;
	}

	private function incrementFileName($file_path,$filename){
		if(count(glob($file_path.$filename))>0){
			$rr = explode(".", $filename);
			$file_ext = end($rr);
			$file_name = str_replace(('.'.$file_ext),"",$filename);
			$newfilename = $file_name.'_'.count(glob($file_path."$file_name*.$file_ext")).'.'.$file_ext;
			return $newfilename;
		}
		else return $filename;
	}

    ///////////////////////////////////////////////////////////////////////	
    ///////////////////////// Ticket part ////////////////////////////
    ///////////////////////////////////////////////////////////////////////

	public function index()
	{
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$user_office_id=get_user_office_id();
			$user_oth_office=get_user_oth_office();
			$is_global_access = get_global_access();
			$data["is_global_access"] = get_global_access();
			
			$user_site_id= get_user_site_id();
						
			$data["qa_is_manager"] = qa_is_manager($current_user);
			$data["is_role_dir"] = get_role_dir();
			$data["aside_template"] = "qa_servicerequest/aside.php";
			$data["content_template"] = "qa_servicerequest/index.php";
			
			$qSql="Select * from signin where status=1 and office_id='$user_office_id' and role_id > 0 and dept_id in (5,6) order by fname";
			$data["user_ticket_list"] = $this->Common_model->get_query_result_array($qSql);
			
			$data["department_data"] = $this->Common_model->get_department_list();
			$data["process_list"] = $this->Common_model->get_process_for_assign();

			$data["priority_dropdown"] = $this->QA_Servicerequest_model->get_priority_list_dropdown();
			$data["category_dropdown"] = $this->QA_Servicerequest_model->get_category_dropdown();
			$data["category_dropdown_form"] = $this->QA_Servicerequest_model->get_category_dropdown_form($current_user);
			$data["sub_category_dropdown"] = $this->QA_Servicerequest_model->get_subcategory_dropdown();

			$data["priority_list"] = $this->QA_Servicerequest_model->get_priority_list_active();
			$data["status_list"] = $this->QA_Servicerequest_model->status_list_active();

			if(get_role_dir()=="super" || $is_global_access==1){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}

			$data["sr_category"] = "";
			$data["sr_sub_category"] = "";

			$data["search"] = "";
			$data["tic_title"] = "New";
			$data["tic_count"] = "";
			$data["sr_priority"] = "";
			$data["sr_status"] = "";
			$data["ticket_view"] = 0;
			$data["transferred"] = 0;
			$data["office_id"] = "";
			
			$search = "";			
			$priority = array();
			$status = array();
			$transferred = 0;
			$sr_category = "0";
			$office_id = "";

			$status_title_heads = array(
				"1" => "New",
				"2" => "In Process",
				"3" => "Put On Hold",
				"4" => "Closed",
				"5" => "Closed As Duplicate",
				"6" => "Re-Opened"
			);

			$priority_title_heads = array(
				"1" => "Priority Normal",
				"2" => "Priority High",
				"3" => "Priority Critical",
			);

			if($this->input->get('sr_status')){
				$status[] = $this->input->get('sr_status');
				$data["sr_status"] =  $this->input->get('sr_status');
				$data["tic_title"] = $status_title_heads[$this->input->get('sr_status')];
			}

			if($this->input->get('office_id')){
				$office_id = $this->input->get('office_id');
				
			}
			if($office_id=="") $office_id=$user_office_id;
			$data["office_id"] = $office_id;
			
			if($this->input->get('sr_priority')){
				$priority[] = $this->input->get('sr_priority');
				$data["sr_priority"] =  $this->input->get('sr_priority');
				$data["tic_title"] = $priority_title_heads[$this->input->get('sr_priority')];
			}

			if(trim($this->input->get("search")!="")){
				$search = $this->input->get("search");	
				$data["tic_title"] = "Searched";
				$data["search"] = $this->input->get("search");			
			}

			if(trim($this->input->get('sr_category')!="")){
				$sr_category = $this->input->get('sr_category');
				$data["sr_category"] = $sr_category;
				if($sr_category != "" && $sr_category >= 1) {
					$data["category_dropdown"] = $this->QA_Servicerequest_model->get_category_dropdown("",$sr_category, $current_user);
				}	
			}

			if(trim($this->input->get('sr_sub_category')!="")){
				$sr_sub_category = $this->input->get('sr_sub_category');
				$data["sr_sub_category"] = $sr_sub_category;
				if($sr_sub_category != "" && $sr_sub_category >=1) {
					$data["sub_category_dropdown"] = $this->QA_Servicerequest_model->get_subcategory_dropdown($sr_category,"",$sr_sub_category);
				}else{
					$data["sub_category_dropdown"] = $this->QA_Servicerequest_model->get_subcategory_dropdown($sr_category);
				}	
			}

			if(trim($this->input->get('sr_transferred')!="")){
				$transferred = $this->input->get('sr_transferred');
				$data["transferred"] = $transferred; 
			}

			if(trim($this->input->get("ticket_view")!="")){
				$my_tickets = $this->input->get("ticket_view");
				$data["ticket_view"] = $my_tickets;
				if($my_tickets == '1') $data["tickets"] = $this->QA_Servicerequest_model->get_all_my_tickets($search, $status, $priority, $transferred, $sr_category);
				else{
					if($is_global_access) $data["tickets"] = $this->QA_Servicerequest_model->get_all_tickets($search, $status, $priority, $transferred, $sr_category, $office_id);
					else $data["tickets"] = $this->QA_Servicerequest_model->get_all_tickets_access_based($search, $status, $priority, $transferred, $sr_category,$office_id);
				}
			}else{				
				if($is_global_access) $data["tickets"] = $this->QA_Servicerequest_model->get_all_tickets($search, $status, $priority, $transferred, $sr_category,$office_id);
				else $data["tickets"] = $this->QA_Servicerequest_model->get_all_tickets_access_based($search, $status, $priority, $transferred, $sr_category,$office_id);
			}
			
			$data["tic_count"] = count($data["tickets"]);

            $this->load->view('dashboard',$data); 
        }
	}
	
	//
	//	ADD TICKET
	//
	public function add_ticket(){
		if(check_logged_in()){
			$current_user = get_user_id();
			$user_office_id = get_user_office_id();
			$user_oth_office = get_user_oth_office();
			$is_global_access = get_global_access();
			$user_site_id = get_user_site_id();

			//$dd = array($current_user, $user_office_id, $user_oth_office, $is_global_access, $user_site_id);

			$_field_arr = array(
				"reference_id" => qa_generate_reference_id(),
				"subject" => htmlentities($this->input->post("subject")),
				"details" => htmlentities($this->input->post("details")),
				"priority_id" => $this->input->post("priority"),
				"office_id" => $user_office_id,
				"department_id" => $user_oth_office,
				"category_id" => $this->input->post("category"),
				"sub_category_id" => $this->input->post("sub_category"),
				"due_date" => $this->input->post('due_date'),
				"created_by" => $current_user
			);

			if($this->input->post("self_submit")==1){
				$_field_arr["self_submit"] = 1 - $this->input->post("self_submit");
				$_field_arr["on_behalf_of"] = htmlentities($this->input->post("on_behalf_of"));
			}

			$record = data_inserter('qa_sr_tickets_tbl', $_field_arr);
			
		////////////////////////	
			$assign_arr = array(
				"ticket_id" => $record,
				"assigned_by" => $current_user,
				"assigned_to" => $this->input->post('assigned_to')
			);
			$rowid = data_inserter('qa_sr_tickets_assignment_tbl', $assign_arr);
		/////////////////////////
			
			if($record){
					
				//
				// Attachments 
				//

				$total = count($_FILES['attachments']['name']);

				if($total > 0){
					if(!is_dir($this->config->item('Qa_ServiceResquestPath') ."/".$record)){
						mkdir($this->config->item('Qa_ServiceResquestPath') ."/".$record, 0777);
					}

					for( $i=0 ; $i < $total ; $i++ ) {
						//Get the temp file path
						$tmpFilePath = $_FILES['attachments']['tmp_name'][$i];
						print($tmpFilePath);
	
						//Make sure we have a file path
						if ($tmpFilePath != ""){
							$filename = $_FILES['attachments']['name'][$i];
							$static_file_path = $this->incrementFileName($this->config->item('ServiceResquestPath') ."/".$record."/",$filename);
							$newFilePath = $this->config->item('Qa_ServiceResquestPath') ."/".$record."/".$static_file_path; 

							//Upload the file into the temp dir
							if(move_uploaded_file($tmpFilePath, $newFilePath)) {
								$_field_arr = array(
									"ticket_id" => $record,
									"file_location" => $static_file_path,
									"uploaded_by" => $current_user
								);
								if(data_inserter('qa_sr_tickets_attachments_tbl', $_field_arr)===false){
									$this->session->set_flashdata('error_msg', 'Error Occurred while uploading attached files. Adding new ticket failed. Try again.');
									redirect(base_url()."qa_servicerequest/");
								}								
							}
						}
					}
				}

				$this->session->set_flashdata('success_msg', 'New Ticket Added Successfully.');
				redirect(base_url()."qa_servicerequest/");

			}else{
				$this->session->set_flashdata('error_msg', 'Error Occurred. Adding new ticket failed. Try again.');
				redirect(base_url()."qa_servicerequest/");
			}
		}
	}


	//
	//	EDIT TICKET
	//
	public function edit(){
		if(check_logged_in()){

			$current_user = get_user_id();
			$user_office_id=get_user_office_id();
			$user_oth_office=get_user_oth_office();
			$is_global_access = get_global_access();
			$user_site_id= get_user_site_id();
			$data["is_global_access"] = get_global_access();
			$data["qa_is_manager"] = qa_is_manager($current_user);
			$data["is_role_dir"] = get_role_dir();
			$data["aside_template"] = "servicerequest/aside.php";
			$data["content_template"] = "servicerequest/edit_ticket.php";
			
			$data["ticket"] = $this->QA_Servicerequest_model->get_ticket($this->uri->segment('4'));
			$data["ticket_attachments"] = $this->QA_Servicerequest_model->ticket_attachments($this->uri->segment('4'));

			$data["ticket_id"] = $this->uri->segment('4');

			$data["priority_dropdown"] = $this->QA_Servicerequest_model->get_priority_list_dropdown($data["ticket_id"]);
			$data["category_dropdown"] = $this->QA_Servicerequest_model->get_category_dropdown($data["ticket_id"]);
			$data["sub_category_dropdown"] = $this->QA_Servicerequest_model->get_subcategory_dropdown("", $data["ticket_id"]);

			if($this->input->post()){

				$record = $this->uri->segment('4');
				
				//
				//	Update Ticket Details
				//
				$_field_arr = array(
					'subject' =>  htmlentities($this->input->post('subject')),
					'details' =>  htmlentities($this->input->post('details')),
					'priority_id' => $this->input->post('priority'),
					'category_id' => $this->input->post('category'),
					'sub_category_id' => $this->input->post('sub_category'),
					'due_date' => $this->input->post('due_date'),
					"updated_on" => date('Y-m-d H:i:a')
				);

				if($this->input->post("self_submit")==1){
					$_field_arr["self_submit"] = 1 - $this->input->post("self_submit");
					$_field_arr["on_behalf_of"] = htmlentities($this->input->post("on_behalf_of"));
				}
	
				$this->db->where('id', $record);
				$this->db->update('qa_sr_tickets_tbl', $_field_arr);

				//
				// Attachments 
				//

				$total = count($_FILES['attachments']['name']);

				if($total > 0){
					if(!is_dir($this->config->item('Qa_ServiceResquestPath') ."/".$record)){
						mkdir($this->config->item('Qa_ServiceResquestPath') ."/".$record, 0777);
					}

					for( $i=0 ; $i < $total ; $i++ ) {
						//Get the temp file path
						$tmpFilePath = $_FILES['attachments']['tmp_name'][$i];
	
						//Make sure we have a file path
						if ($tmpFilePath != ""){	
							$filename = $_FILES['attachments']['name'][$i];

							$static_file_path = $this->incrementFileName($this->config->item('Qa_ServiceResquestPath') ."/".$record."/",$filename);
							$newFilePath = $this->config->item('Qa_ServiceResquestPath') ."/".$record."/".$static_file_path; 

							//Upload the file into the temp dir
							if(move_uploaded_file($tmpFilePath, $newFilePath)) {
								$_field_arr = array(
									"ticket_id" => $record,
									"file_location" => $static_file_path,
									"uploaded_by" => $current_user
								);
								data_inserter('qa_sr_tickets_attachments_tbl', $_field_arr);
							}
						}
					}
				}
				redirect(base_url()."qa_servicerequest/ticket/".$record);
			}

			$this->load->view('dashboard', $data);
		}
	}

	//
	//	GET SUB CATEGORY
	//
	public function get_sub_category(){
		if(check_logged_in()){
			print $this->QA_Servicerequest_model->get_subcategory_dropdown($this->input->post('category_id'));
		}
	}


	//
	//	USER LIST FOR ASSIGNMENT
	//
	public function user_list(){
		if(check_logged_in()){
			$result = $this->QA_Servicerequest_model->get_assign_list_all($this->input->post('office_id'));

			$html = "<option value=''></option>";
			foreach($result as $row){
				$html .= "<option value='".$row->id."'>".$row->tl_name."</option>";
			}
			print $html;
		}
	}

	//
	//	VIEW TICKET DETAILS
	//
	public function ticket($_id){
		if(check_logged_in()){
			$current_user = get_user_id();
			$user_office_id=get_user_office_id();
			$user_oth_office=get_user_oth_office();
			$is_global_access = get_global_access();
			$user_site_id= get_user_site_id();
			$data["is_global_access"] = get_global_access();			
			$data["qa_is_manager"] = qa_is_manager($current_user);
			$data["is_role_dir"] = get_role_dir();
			$data["aside_template"] = "qa_servicerequest/aside.php";
			$data["content_template"] = "qa_servicerequest/ticket.php";


			$data["current_user"] = $current_user;
			$data["ticket"] = $this->QA_Servicerequest_model->get_ticket($_id);
			$data["ticket_id"] = $data["ticket"][0]->id;
			//$data["ticket_replies"] = $this->QA_Servicerequest_model->get_ticket_replies($_id);

			$data["ticket_me"] = $this->QA_Servicerequest_model->ticket_assigned_user($_id);
			//$data["assigned_user_list"] = $this->QA_Servicerequest_model->get_assigned_users($_id);
			
			$data["assigned_users"] = $this->QA_Servicerequest_model->get_assign_list_all($_id);
			$data["pre_assign_users"] = $this->QA_Servicerequest_model->get_pre_assign_list($_id);
			
			$data["is_ticket_creator"] = $this->QA_Servicerequest_model->ticket_creator($_id);
			
			$data["ticket_replies"] = $this->QA_Servicerequest_model->get_ticket_replies($_id);
			$data["ticket_attachments"] = $this->QA_Servicerequest_model->ticket_attachments($_id);

			$data["priority_dropdown"] = $this->QA_Servicerequest_model->get_priority_list_dropdown();
			$data["category_dropdown"] = $this->QA_Servicerequest_model->get_category_dropdown();

			$data["transfer_tickets"] = $this->QA_Servicerequest_model->transfer_ticket_details($_id);
			$data["ticket_status_logs"] = $this->QA_Servicerequest_model->ticket_status_logs($_id);
			
			$qSql="Select * from signin where status=1 and office_id='$user_office_id' and role_id > 0 and dept_id in (5,6) order by fname";
			$data["user_ticket_list"] = $this->Common_model->get_query_result_array($qSql);

            $this->load->view('dashboard',$data); 
		}
	}

	//
	//	TAKEOVER TICKET
	//
	public function takeover_ticket(){
		if(check_logged_in()){
			if(trim($this->input->post('id'))!="" && trim($this->input->post('created_by'))!=""){
				$current_user = get_user_id();

				// update ticket table
				$data['status_id'] = 2;
				$data['status_updated_by'] = $current_user;
				$this->db->where('id', $this->input->post('id'));
				$this->db->update('qa_sr_tickets_tbl', $data);
				
				
				$ticket_id = $this->input->post('id');
				$evt_date = CurrMySqlDate();
				
				//$this->QA_Servicerequest_model->delete_assigned_users($this->input->post('id'));
				
				$rSql= "REPLACE INTO  qa_sr_tickets_assignment_tbl(ticket_id,assigned_by,assigned_to,taken_over,taken_over_on)values(".$ticket_id.",'".$current_user."','".$current_user."','1','".$evt_date."')";

				$this->db->query($rSql);
				
				print true;
				
			}else print false;
		}
	}

	//
	//	IN PROCESS TICKET
	//
	public function status_inprocess(){
		if(check_logged_in()){
			if(trim($this->input->post('id'))!=""){

				$current_user = get_user_id();

				// update ticket table
				$data['status_id'] = 2;
				$data['status_updated_by'] = $current_user;
				$this->db->where('id', $this->input->post('id'));
				$this->db->update('qa_sr_tickets_tbl', $data);

				// status changes log
				$_field_arr = array(
					"ticket_id" => $this->input->post('id'),
					"status_id" => 2,
					"changed_by" => $current_user
				);

				data_inserter('qa_sr_status_changes_tbl', $_field_arr);

				//
				// Automatic assign this current user
				/*
				$taken_over["taken_over"] = 1;
				$taken_over["taken_over_on"] = date('Y-m-d H:i:a');

				$ts = array(
					'ticket_id' => $this->input->post('id'),
					'assigned_to' => $current_user
				);

				$this->db->where($ts);
				$this->db->update('qa_sr_tickets_assignment_tbl', $taken_over);
				*/
				
				$ticket_id = $this->input->post('id');
				$evt_date = CurrMySqlDate();
				//$this->QA_Servicerequest_model->delete_assigned_users($this->input->post('id'));
				$rSql= "REPLACE INTO  qa_sr_tickets_assignment_tbl(ticket_id,assigned_by,assigned_to,taken_over,taken_over_on)values(".$ticket_id.",'".$current_user."','".$current_user."','1','".$evt_date."')";

				$this->db->query($rSql);
				
				print true;
			}else print false;
		}
	}

	//
	//	PUT ON HOLD TICKET
	//
	public function status_putonhold(){
		if(check_logged_in()){
			if(trim($this->input->post('id'))!=""){

				$current_user = get_user_id();

				// update ticket table
				$data['status_id'] = 3;
				$data['status_updated_by'] = $current_user;
				$this->db->where('id', $this->input->post('id'));
				$this->db->update('qa_sr_tickets_tbl', $data);

				// status changes log
				$_field_arr = array(
					"ticket_id" => $this->input->post('id'),
					"status_id" => 3,
					"changed_by" => $current_user
				);

				data_inserter('qa_sr_status_changes_tbl', $_field_arr);

				//
				// Automatic assign this current user
				/*
				$taken_over["taken_over"] = 1;
				$taken_over["taken_over_on"] = date('Y-m-d H:i:a');

				$ts = array(
					'ticket_id' => $this->input->post('id'),
					'assigned_to' => $current_user
				);

				$this->db->where($ts);
				$this->db->update('qa_sr_tickets_assignment_tbl', $taken_over);
				*/
				
				$ticket_id = $this->input->post('id');
				$evt_date = CurrMySqlDate();
				//$this->QA_Servicerequest_model->delete_assigned_users($this->input->post('id'));
				$rSql= "REPLACE INTO  qa_sr_tickets_assignment_tbl(ticket_id,assigned_by,assigned_to,taken_over,taken_over_on)values(".$ticket_id.",'".$current_user."','".$current_user."','1','".$evt_date."')";

				$this->db->query($rSql);
				
				
				print true;
			}else print false;
		}
	}

	//
	//	CLOSE TICKET
	//
	public function status_closed(){
		if(check_logged_in()){
			if(trim($this->input->post('id'))!=""){

				$current_user = get_user_id();

				// update ticket table
				$data['status_id'] = 4;
				$data['status_updated_by'] = $current_user;
				$data['closed'] = true;
				$data['closed_by'] = $current_user;
				$data['closed_on'] = date('Y-m-d H:i:a');

				$this->db->where('id', $this->input->post('id'));
				$this->db->update('qa_sr_tickets_tbl', $data);

				// status changes log
				$_field_arr = array(
					"ticket_id" => $this->input->post('id'),
					"status_id" => 4,
					"changed_by" => $current_user
				);

				data_inserter('qa_sr_status_changes_tbl', $_field_arr);
				
				$ticket_id = $this->input->post('id');
				$evt_date = CurrMySqlDate();
				//$this->QA_Servicerequest_model->delete_assigned_users($this->input->post('id'));
				$rSql= "REPLACE INTO  qa_sr_tickets_assignment_tbl(ticket_id,assigned_by,assigned_to,taken_over,taken_over_on)values(".$ticket_id.",'".$current_user."','".$current_user."','1','".$evt_date."')";

				$this->db->query($rSql);
				

				print true;
			}else print false;
		}
	}

	//
	//	REOPEN TICKET
	//
	public function status_reopen(){
		if(check_logged_in()){
			if(trim($this->input->post('id'))!=""){

				$current_user = get_user_id();

				// update ticket table
				$data['status_id'] = 6;
				$data['status_updated_by'] = $current_user;
				$data['closed'] = false;
				$data['closed_by'] = NULL;
				$data['closed_on'] = NULL;

				$this->db->where('id', $this->input->post('id'));
				$this->db->update('qa_sr_tickets_tbl', $data);

				// status changes log
				$_field_arr = array(
					"ticket_id" => $this->input->post('id'),
					"status_id" => 6,
					"changed_by" => $current_user
				);

				data_inserter('qa_sr_status_changes_tbl', $_field_arr);
				
				$ticket_id = $this->input->post('id');
				$evt_date = CurrMySqlDate();
				//$this->QA_Servicerequest_model->delete_assigned_users($this->input->post('id'));
				$rSql= "REPLACE INTO  qa_sr_tickets_assignment_tbl(ticket_id,assigned_by,assigned_to,taken_over,taken_over_on)values(".$ticket_id.",'".$current_user."','".$current_user."','1','".$evt_date."')";

				$this->db->query($rSql);

				print true;
			}else print false;
		}
	}

	//
	//	REPLY TO TICKET
	//
	public function ticket_replies(){
		if(check_logged_in()){
			if(trim($this->input->post('ticket_id'))!=""){

				$current_user = get_user_id();

				$_field_arr = array(
					"ticket_id" => $this->input->post('ticket_id'),
					"reply_by" => $current_user,
					"subject" => $this->input->post('subject'),
					"details" => $this->input->post('details') 
				);
				$_id = data_inserter('qa_sr_tickets_reply_tbl', $_field_arr);

				// update ticket table
				$data['status_id'] = 2;
				$data['status_updated_by'] = $current_user;
				$this->db->where('id', $this->input->post('ticket_id'));
				$this->db->update('qa_sr_tickets_tbl', $data);

				// status changes log
				$_field_arr = array(
					"ticket_id" => $this->input->post('ticket_id'),
					"status_id" => 2,
					"changed_by" => $current_user
				);

				data_inserter('qa_sr_status_changes_tbl', $_field_arr);
				
				$ticket_id = $this->input->post('ticket_id');
				$evt_date = CurrMySqlDate();
				//$this->QA_Servicerequest_model->delete_assigned_users($this->input->post('ticket_id'));
				$rSql= "REPLACE INTO  qa_sr_tickets_assignment_tbl(ticket_id,assigned_by,assigned_to,taken_over,taken_over_on)values(".$ticket_id.",'".$current_user."','".$current_user."','1','".$evt_date."')";

				$this->db->query($rSql);
				
				//
				//
				
				$record = $this->input->post('ticket_id');

				//
				// Attachments 
				//

				$total = count($_FILES['reply_attachments']['name']);

				if($total > 0){
					if(!is_dir($this->config->item('Qa_ServiceResquestPath') ."/".$record)){
						mkdir($this->config->item('Qa_ServiceResquestPath') ."/".$record, 0777);
					}

					for( $i=0 ; $i < $total ; $i++ ) {
						//Get the temp file path
						$tmpFilePath = $_FILES['reply_attachments']['tmp_name'][$i];
	
						//Make sure we have a file path
						if ($tmpFilePath != ""){	
							$filename = $_FILES['reply_attachments']['name'][$i];

							$static_file_path = $this->incrementFileName($this->config->item('ServiceResquestPath') ."/".$record."/",$filename);
							$newFilePath = $this->config->item('Qa_ServiceResquestPath') ."/".$record."/".$static_file_path; 

							//Upload the file into the temp dir
							if(move_uploaded_file($tmpFilePath, $newFilePath)) {
								$_field_arr = array(
									"ticket_id" => $record,
									"file_location" => $static_file_path,
									"uploaded_by" => $current_user,
									"reply_id" => $_id,
								);
								data_inserter('qa_sr_tickets_attachments_tbl', $_field_arr);
							}
						}
					}
				}

				redirect(base_url()."qa_servicerequest/ticket/".$this->input->post('ticket_id'));
			}
		}
	}

	//
	//	CLOSE AS DUPLICATE
	//
	public function close_as_duplicate(){
		if(check_logged_in()){
			if(trim($this->input->post('id'))!=""){

				$current_user = get_user_id();

				//
				//
				$data["status_id"] = 5;
				$data["status_updated_by"] = $current_user;
				$data["closed"] = 1;
				$data["closed_by"] = $current_user;
				$data["closed_on"] = date('Y-m-d H:i:a');
				
				$this->db->where('id', $this->input->post('id'));
				$this->db->update('qa_sr_tickets_tbl', $data);

				//
				//
				$_field_arr = array(
					"ticket_id" => $this->input->post('id'),					
					"status_id" => 5,
					"changed_by" => $current_user,
				);
				data_inserter('qa_sr_status_changes_tbl', $_field_arr);
				
				$ticket_id = $this->input->post('id');
				$evt_date = CurrMySqlDate();
				//$this->QA_Servicerequest_model->delete_assigned_users($this->input->post('id'));
				$rSql= "REPLACE INTO  qa_sr_tickets_assignment_tbl(ticket_id,assigned_by,assigned_to,taken_over,taken_over_on)values(".$ticket_id.",'".$current_user."','".$current_user."','1','".$evt_date."')";

				$this->db->query($rSql);
				
				print true;
			}
		}
	}

	//
	//	REPLY AND CLOSE
	//
	public function reply_and_close(){		
		if(check_logged_in()){

			if(trim($this->input->post('ticket_id'))!=""){

				$current_user = get_user_id();

				//
				// add reply
				$_field_arr = array(
					"ticket_id" => $this->input->post('ticket_id'),
					"reply_by" => $current_user,
					"subject" => $this->input->post('subject'),
					"details" => $this->input->post('details') 
				);
				$_id = data_inserter('qa_sr_tickets_reply_tbl', $_field_arr);
				
				$ticket_id = $this->input->post('ticket_id');
				$evt_date = CurrMySqlDate();
				//$this->QA_Servicerequest_model->delete_assigned_users($this->input->post('ticket_id'));
				$rSql= "REPLACE INTO  qa_sr_tickets_assignment_tbl(ticket_id,assigned_by,assigned_to,taken_over,taken_over_on)values(".$ticket_id.",'".$current_user."','".$current_user."','1','".$evt_date."')";

				$this->db->query($rSql);
				
				//
				// close ticket
				$data["status_id"] = 4;
				$data["status_updated_by"] = $current_user;
				$data["closed"] = 1;
				$data["closed_by"] = $current_user;
				$data["closed_on"] = $evt_date;
				
				$this->db->where('id', $this->input->post('ticket_id'));
				$this->db->update('qa_sr_tickets_tbl', $data);

				//
				// log status
				$_field_arr = array(
					"ticket_id" => $this->input->post('ticket_id'),					
					"status_id" => 4,
					"changed_by" => $current_user,
				);
				data_inserter('qa_sr_status_changes_tbl', $_field_arr);

				//
				// Attachments 
				//

				$record = $this->input->post('ticket_id');

				$total = count($_FILES['reply_attachments']['name']);

				if($total > 0){
					if(!is_dir($this->config->item('Qa_ServiceResquestPath') ."/".$record)){
						mkdir($this->config->item('Qa_ServiceResquestPath') ."/".$record, 0777);
					}

					for( $i=0 ; $i < $total ; $i++ ) {
						//Get the temp file path
						$tmpFilePath = $_FILES['reply_attachments']['tmp_name'][$i];
	
						//Make sure we have a file path
						if ($tmpFilePath != ""){	
							$filename = $_FILES['reply_attachments']['name'][$i];

							$static_file_path = $this->incrementFileName($this->config->item('Qa_ServiceResquestPath') ."/".$record."/",$filename);
							$newFilePath = $this->config->item('Qa_ServiceResquestPath') ."/".$record."/".$static_file_path; 

							//Upload the file into the temp dir
							if(move_uploaded_file($tmpFilePath, $newFilePath)) {
								$_field_arr = array(
									"ticket_id" => $record,
									"file_location" => $static_file_path,
									"uploaded_by" => $current_user,
									"reply_id" => $_id,
								);
								data_inserter('qa_sr_tickets_attachments_tbl', $_field_arr);
							}
						}
					}
				}

				redirect(base_url()."qa_servicerequest/ticket/".$this->input->post('ticket_id'));
			}
		}
	}

	//
	//	DELETE ATTACHMENTS
	//
	public function delete_attachments(){
		if(check_logged_in()){
			if(trim($this->input->post('id'))!=""){
				$this->QA_Servicerequest_model->delete_reply_attachments($this->input->post('id'));
			}
			print 1;
		}
	}

	//
	//	TRANSFER TICKET
	//
	public function transfer_ticket(){
		if(check_logged_in()){
			if(trim($this->input->post('id'))!=""){
				$current_user = get_user_id();

				$ticket = $this->QA_Servicerequest_model->get_ticket($this->input->post('id'));
				
				$transfer_assigned_arr = array(
					"ticket_id" => $this->input->post("id"),
					"assigned_by" => $current_user,
					"assigned_to" => $this->input->post("assigned_to")
				);
				data_inserter("qa_sr_tickets_assignment_tbl", $transfer_assigned_arr);
				
				$_field_arr = array(
					"ticket_id" => $this->input->post("id"),
					"details" => $this->input->post("details"),
					"transferred_by" => $current_user,
					"transferred_to_category_id" => $this->input->post("category"),
					"transferred_from_category_id" => $ticket[0]->category_id,
					"transferred_to_sub_category_id" => $this->input->post("sub_category"),
					"transferred_from_sub_category_id" => $ticket[0]->sub_category_id,
				);
				data_inserter("qa_sr_tickets_transfer_tbl", $_field_arr);
				
				//$this->db->query($rSql);

				$data = array("category_id" => $this->input->post("category"), "sub_category_id" => $this->input->post("sub_category"));
				$this->db->where('id', $this->input->post('id'));
				$this->db->update('qa_sr_tickets_tbl', $data);
				
				redirect(base_url()."qa_servicerequest/ticket/".$this->input->post('id'));
			}
		}
	}

	//********************************************************************/
	//	REPORTS BUILD PAGE
	//********************************************************************/

	public function reports(){
		if(check_logged_in()){

			$current_user = get_user_id();
			$user_office_id=get_user_office_id();
			$office_id=$user_office_id;
			
			$user_oth_office=get_user_oth_office();
			$is_global_access = get_global_access();
			$user_site_id= get_user_site_id();
			
			$data["is_global_access"] = get_global_access();
			$data["qa_is_manager"] = qa_is_manager($current_user);
			$data["is_role_dir"] = get_role_dir();
			$data["aside_template"] = "qa_servicerequest/aside.php";
			$data["content_template"] = "qa_servicerequest/reports.php";

			$data["category_dropdown"] = $this->QA_Servicerequest_model->get_category_dropdown();
			$data["status_dropdown"] = $this->QA_Servicerequest_model->status_list_active();
			$data['location_list'] = $this->Common_model->get_office_location_list();
			
			/* if(get_role_dir()=="super" || $is_global_access==1){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			} */
			

			$data["ticket_reports"] = [];
			$data["filename"] = "";

			if($this->input->post()){
				
				$office_id = $this->input->post('office_id');
				if($office_id=="")  $office_id=$user_office_id;
				
				$category = $this->input->post('category');
				$sub_category = $this->input->post('sub_category');
				$status = $this->input->post('status');

				$data["category_dropdown"] = $this->QA_Servicerequest_model->get_category_dropdown("", $this->input->post('category'));
				$data["sub_category_dropdown"] = $this->QA_Servicerequest_model->get_subcategory_dropdown($this->input->post('category'),"", $sub_category);
				
				$data["ticket_reports"] = $this->QA_Servicerequest_model->ticket_reports($office_id,$category, $sub_category, $status);
												
			}
			$data["office_id"] = $office_id;
			
			$this->load->view('dashboard',$data); 
		}
	}
	
	//********************************************************************/
	//	REPORTS BUILD PAGE
	//********************************************************************/

	public function download(){
		
		if(check_logged_in()){
			if($this->input->post()){
				$currDate=date("Y-m-d");
				$newfile="qa_servicerequest_report-".$currDate.".xlsx";

				$office_id = $this->input->post('office_id');
				if($office_id=="")  $office_id=$user_office_id;
				
				$category = $this->input->post('category');
				$sub_category = $this->input->post('sub_category');
				$status = $this->input->post('status');

				$office_id = $this->input->post('office_id');
				if($office_id=="")  $office_id=$user_office_id;
			
				$data["category_dropdown"] = $this->QA_Servicerequest_model->get_category_dropdown("", $this->input->post('category'));
				$data["sub_category_dropdown"] = $this->QA_Servicerequest_model->get_subcategory_dropdown($this->input->post('category'),"", $sub_category);
				
				$data["ticket_reports"] = $this->QA_Servicerequest_model->ticket_reports($office_id,$category, $sub_category, $status);
				
				//
				// EXCEL
				//

				$no_of_reply_cols = 3 * $this->QA_Servicerequest_model->get_max_no_reply_columns();

				$this->objPHPExcel->createSheet();
				$this->objPHPExcel->setActiveSheetIndex(0);
				$objWorksheet = $this->objPHPExcel->getActiveSheet();
				$objWorksheet->setTitle('Service Request Tickets');
				$objWorksheet->getDefaultColumnDimension()->setAutoSize(true);

				// CELL FONT AND FONT COLOR 

				$styleArray = array(
					'font' => array(
							'bold'  => true,
							'color' => array('rgb' => '000000'),
							'size'  => 9
					),
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					),
					'borders' => array(
						'allborders' => array(
							'style' => PHPExcel_Style_Border::BORDER_THICK,
							'color' => array(
								'rgb' => '000000'
							)
						)
					),
					'fill' => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'color' => array('rgb'=>'538DD5'),
					)
				);

				$styleArray2 = array(
					'font' => array(
							'bold'  => true,
							'color' => array('rgb' => '000000'),
							'size'  => 9
					),
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					),
					'borders' => array(
						'allborders' => array(
							'style' => PHPExcel_Style_Border::BORDER_THICK,
							'color' => array(
								'rgb' => '000000'
							)
						)
					),
					'fill' => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'color' => array('rgb'=>'948A54'),
					)
				);

				$colStyle = array(
					'font' => array(
						'bold'  => false,
						'color' => array('rgb' => '000000'),
						'size'  => 9
					),
					'borders' => array(
						'allborders' => array(
							'style' => PHPExcel_Style_Border::BORDER_THICK,
							'color' => array('rgb' => '000000')
						)
					),
					'alignment' => array(
						'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP,
					),
				);

				$objWorksheet->getDefaultStyle()->applyFromArray($colStyle);
				$objWorksheet->getDefaultStyle()->getAlignment()->setWrapText(true);

				// START GRIDLINES HIDE AND SHOW//
				$objWorksheet->setShowGridlines(true);

				$header = ["Ticket ID", "Reference ID", "Created On", "Created By ID", "Created By Name", "Subject", "Details", "Priority", "Status", "Category", "Sub Category", "Closed On", "Closed By ID", "Closed By Name", "Submitted For Self", "Submitted On Behalf Of"];

				$row = 1;

				for($i = 0; $i <= count($header); $i++){					
					$objWorksheet->setCellValueByColumnAndRow($i,$row,$header[$i]);	
					$objWorksheet->getStyle(PHPExcel_Cell::stringFromColumnIndex($i).$row)->applyFromArray($styleArray);				
				}
				
				$rep_col = ord($objWorksheet->getHighestColumn())-65;

				print $rep_col."<br>";

				$j = 1;
				$temp = $j;
				for($i=$rep_col; $i<($no_of_reply_cols+$rep_col); $i++, $temp++){	
					print $i."---->?".$j."--".$temp."<br>";		
					if($i==$rep_col){
						$merge = PHPExcel_Cell::stringFromColumnIndex($i).$row.":".PHPExcel_Cell::stringFromColumnIndex($i + 2).$row;					
						$objWorksheet->mergeCells($merge);
						$objWorksheet->setCellValueByColumnAndRow($i,$row,"Reply".$j);	
						$objWorksheet->getStyle(PHPExcel_Cell::stringFromColumnIndex($i).$row)->applyFromArray($styleArray);
						$objWorksheet->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($i))->setWidth("30");
						$temp++;	
						$j++;
					}else{
						if($temp == 3 || $temp % 3 == 0){
							$merge = PHPExcel_Cell::stringFromColumnIndex($i).$row.":".PHPExcel_Cell::stringFromColumnIndex($i + 2).$row;					
							$objWorksheet->mergeCells($merge);
							$objWorksheet->setCellValueByColumnAndRow($i,$row,"Reply".$j);	
							$objWorksheet->getStyle(PHPExcel_Cell::stringFromColumnIndex($i).$row)->applyFromArray($styleArray);
							$objWorksheet->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($i))->setWidth("30");
							$j++;
						}
						$temp += 2;							
					}		
					$i += 2;
													
				}

				// Row-2
				$row += 1;
				for($i = $rep_col; $i<($no_of_reply_cols+$rep_col); $i = $i+3){
					$re_header = ["Reply Details", "Replied By", "Replied On"];
					$x = $i;
					foreach($re_header as $reply){						
						$objWorksheet->setCellValueByColumnAndRow($x,$row,$reply);
						$objWorksheet->getStyle(PHPExcel_Cell::stringFromColumnIndex($x).$row)->applyFromArray($styleArray2);
						$x++;	
					}
				}

				// Row-3 Onwards
				$row += 1;
				foreach($data["ticket_reports"] as $ticket){
					$i = 0;

					$objWorksheet->getStyleByColumnAndRow($i, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
					$objWorksheet->setCellValueByColumnAndRow($i,$row,$ticket->id);	
					
					$objWorksheet->getStyleByColumnAndRow($i+= 1, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
					$objWorksheet->setCellValueByColumnAndRow($i ,$row,$ticket->reference_id);	
					
					$objWorksheet->getStyleByColumnAndRow($i+= 1, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
					$objWorksheet->setCellValueByColumnAndRow($i,$row,$ticket->created_on);							
					
					$objWorksheet->getStyleByColumnAndRow($i+= 1, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
					$objWorksheet->setCellValueByColumnAndRow($i,$row,$ticket->fusion_idcr);														
					
					$objWorksheet->getStyleByColumnAndRow($i+= 1, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
					$objWorksheet->setCellValueByColumnAndRow($i,$row,$ticket->created_by_name);								
					
					$objWorksheet->getStyleByColumnAndRow($i+= 1, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
					$objWorksheet->setCellValueByColumnAndRow($i,$row,$ticket->subject);	
					$objWorksheet->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($i))->setWidth("30");							
					
					$objWorksheet->getStyleByColumnAndRow($i+= 1, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
					$objWorksheet->setCellValueByColumnAndRow($i,$row,str_replace('&nbsp;',' ',stripslashes(strip_tags(html_entity_decode($ticket->details)))));									
					$objWorksheet->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($i))->setWidth("30");

					$objWorksheet->getStyleByColumnAndRow($i+= 1, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
					$objWorksheet->setCellValueByColumnAndRow($i,$row,$ticket->priority_name);									
					
					$objWorksheet->getStyleByColumnAndRow($i+= 1, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
					$objWorksheet->setCellValueByColumnAndRow($i,$row,$ticket->status_name);													
					
					$objWorksheet->getStyleByColumnAndRow($i+= 1, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
					$objWorksheet->setCellValueByColumnAndRow($i,$row,$ticket->category);									
					
					$objWorksheet->getStyleByColumnAndRow($i+= 1, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
					$objWorksheet->setCellValueByColumnAndRow($i,$row,$ticket->sub_category);										
					
					$objWorksheet->getStyleByColumnAndRow($i+= 1, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
					$objWorksheet->setCellValueByColumnAndRow($i,$row,$ticket->closed_on);											
					
					$objWorksheet->getStyleByColumnAndRow($i+= 1, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
					$objWorksheet->setCellValueByColumnAndRow($i,$row,$ticket->fusion_idcl);										
					
					$objWorksheet->getStyleByColumnAndRow($i+= 1, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
					$objWorksheet->setCellValueByColumnAndRow($i,$row,$ticket->closed_by_name);							
					
					$objWorksheet->getStyleByColumnAndRow($i+= 1, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
					if($ticket->self_submit == 1) $objWorksheet->setCellValueByColumnAndRow($i,$row,"Yes");
					else $objWorksheet->setCellValueByColumnAndRow($i,$row,"No");												
					
					$objWorksheet->getStyleByColumnAndRow($i+= 1, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
					$objWorksheet->setCellValueByColumnAndRow($i,$row,$ticket->behalf_of_user);							
					

					/* GET REPLIES */
					
					$replies = $this->QA_Servicerequest_model->get_ticket_replies($ticket->id);
					
					foreach($replies as $reply){
						$objWorksheet->setCellValueByColumnAndRow($i+= 1, $row, str_replace("&nbsp;","",stripslashes(strip_tags(html_entity_decode($reply->details)))));	
						$objWorksheet->setCellValueByColumnAndRow($i+= 1, $row, $reply->reply_by);	
						$objWorksheet->setCellValueByColumnAndRow($i+= 1, $row, $reply->reply_on);							
					}

					$row +=1;
				}
				header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
				header('Content-Disposition: attachment;filename="'.$newfile.'"');
				header('Cache-Control: max-age=0');
				$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
				$objWriter->setIncludeCharts(TRUE);
				ob_end_clean();
				$objWriter->save('php://output');
				exit(); 
			}		
		}
	}

		
	public function manage_category_access(){
		$current_user = get_user_id();
		$user_office_id=get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access = get_global_access();
		$data["is_global_access"] = get_global_access();
		
		$user_site_id= get_user_site_id();
					
		$data["qa_is_manager"] = qa_is_manager($current_user);
		$data["is_role_dir"] = get_role_dir();
		$data["aside_template"] = "servicerequest/aside.php";
		$data["content_template"] = "servicerequest/manage_category_access.php";

		$this->load->view('dashboard',$data); 
	}


}


