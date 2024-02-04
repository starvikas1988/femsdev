<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dynamic_pop_up extends CI_Controller {
    
    private $aside = "dynamic_pop_up/aside.php";
	 function __construct() {
		parent::__construct();
		$this->load->model('auth_model');
		$this->load->model('Common_model');
	 }

	private function check_access()
	{
		if(get_global_access()!='1' && get_dept_folder() !="hr" && get_role_dir()!="super") redirect(base_url()."home","refresh");
	} 
	
    public function index()
    {			
		if(check_logged_in())
        {	
        	$this->check_access();

			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_id();
			$user_fusion_id = get_user_fusion_id();
			$data["aside_template"] = $this->aside;
			$data["content_template"] = "dynamic_pop_up/form.php";
			// if(get_role_dir()=="super" || $is_global_access==1){
			// 	//return all office location list
			// 	$data['location_list'] = $this->Common_model->get_office_location_list();
			// }else{
			// 	//return all office location list for particular list
			// 	$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			// }
			// $data['client_list'] = $this->Common_model->get_client_list_array();
			// $data['process_list'] = $this->Common_model->get_process_list_1();
			$data["location_data"] = $this->Common_model->get_office_location_list();
			$data['client_list'] = $this->Common_model->get_client_list();	
			$data['process_list'] = $this->Common_model->get_process_for_assign();
            // $data["content_js"] = "dynamic_pop_up/dynamic_pop_up_js.php";
			$qSql = "Select id, fusion_id, concat(fname, ' ', lname) as name from signin where status=1 and role_id not in (select id from role where folder='agent') order by name asc ";
			$data["user_tlmanager"] = $this->Common_model->get_query_result_array($qSql);
            $data["error"] = '';
			$this->load->view('dashboard',$data);
								
        }			
	}
	
    public function action()
	{  
		$tablename = 'dynamic_pop_up';
		$current_user   = get_user_id();
		$user_fusion_id = get_user_fusion_id();
		//$data = $this->input->post();
		$file = $_FILES['file']['name'];
		$femsid='';
		$team='';
		$client='';
		$process='';
		$location='';
		$update_id='';
		$user_fems_id='';

		$preferances = $this->input->post('preferances');
		if($preferances=='Individual'){
			$femsid = $this->input->post('femsid');
		}
		if($preferances=='Team'){
			$team = implode(",",$this->input->post('l1Super'));
		}
		if($preferances=='Client'){
			$client = implode(",",$this->input->post('client'));
		}
		if($preferances=='Process'){
			$client = implode(",",$this->input->post('client'));
			$process = implode(",",$this->input->post('process'));
		}

		if($preferances=='Location'){
			$location    = implode(",",$this->input->post('location'));
		}
		$start_date  = $this->input->post('start_date');
		$end_date    = $this->input->post('end_date');
		$update_id    = $this->input->post('update_id');
		$user_fems_id    = $this->input->post('user_fems_id');
		$file_name   = $file;
		$data = array(
			'fems_id'=>$user_fusion_id,
			'user_id'=>$current_user,
			'location'=>$location,
			'process'=>$process,
			'client'=>$client,
			'preferances'=>$preferances,
			'femsid'=>$femsid,
			'team'=>$team,
			'start_time'=>$start_date,
			'end_time'=>$end_date
		);    
		//echo'<pre>';print_r($data);die();
		if(check_logged_in()){

			if($file!=""){
				$data['image_path'] = $this->do_upload('file',$file);
			}
			if(!empty($update_id)){
				if($user_fems_id==$user_fusion_id){
					$this->db->where('id', $update_id);
					$update = $this->db->update($tablename, $data);
					if (!empty($update)) {
						echo '<script type="text/javascript">'; 
						echo 'alert("Form Updated Sucessfully");'; 
						echo 'window.location.href = "'.base_url().'dynamic_pop_up";';
						echo '</script>';
						// $msg = "Form Updated Sucessfully"; 
					}else{
						echo '<script type="text/javascript">'; 
						echo 'alert("Something went wrong");'; 
						echo 'window.location.href = "'.base_url().'dynamic_pop_up";';
						echo '</script>';
						// $msg='Something went wrong';
					}
				}else{
					    echo '<script type="text/javascript">'; 
						echo 'alert("Something went wrong");'; 
						echo 'window.location.href = "'.base_url().'dynamic_pop_up";';
						echo '</script>';
					// $msg='Something went wrong';
				}
				
			}else{
				if($data['image_path'] != ""){
					$msg='';
					$this->db->insert($tablename, $data);
					$insert_id = $this->db->insert_id();
					if (!empty($insert_id)) {
						echo '<script type="text/javascript">'; 
						echo 'alert("Form Submitted Sucessfully");'; 
						echo 'window.location.href = "'.base_url().'dynamic_pop_up";';
						echo '</script>';
						// $msg = "Form Submitted Sucessfully"; 
					}else{
						echo '<script type="text/javascript">'; 
						echo 'alert("Something went wrong");'; 
						echo 'window.location.href = "'.base_url().'dynamic_pop_up";';
						echo '</script>';
						// $msg='Something went wrong';
					}
				}else{
					echo '<script type="text/javascript">'; 
						echo 'alert("File upload error");'; 
						echo 'window.location.href = "'.base_url().'dynamic_pop_up";';
						echo '</script>';
					// $msg='file upload error';
				}
			}
			
			// echo json_encode(array('msg' => $msg));
		}
    }

    public function do_upload($fileName,$image)
    {
		$config['upload_path']          = "./uploads/dynamic_pop_up/";
        $config['allowed_types']        = 'gif|jpg|png|jpeg';

        $this->load->library('upload', $config);
 
    	if ( ! $this->upload->do_upload($fileName))
        {
        	 return "";
        }else{
        	return $this->upload->data('file_name');
        }
        
    }
	public function show(){
		$data['user_fusion_id'] = get_user_fusion_id();
		$cur_date = date("Y-m-d h:i:s");
		$qSql = "SELECT * from dynamic_pop_up where '$cur_date' >= start_time and '$cur_date' <= end_time and deleted=0";
		$data['list'] = $this->Common_model->get_query_result_array($qSql);
		$data["aside_template"] = $this->aside;
		$data["content_template"] = "dynamic_pop_up/list.php";
		$this->load->view('dashboard',$data);
	}
	public function edit($id){
		$data['user_fusion_id'] = get_user_fusion_id();
		$qSql = "SELECT * from dynamic_pop_up where id=$id and deleted=0";
		$data['pop_up'] = $this->Common_model->get_query_result_array($qSql);
		$qSql = "Select id, fusion_id, concat(fname, ' ', lname) as name from signin where status=1 and role_id not in (select id from role where folder='agent') order by name asc ";
		$data["user_tlmanager"] = $this->Common_model->get_query_result_array($qSql);
		$data["location_data"] = $this->Common_model->get_office_location_list();
		$data['client_list'] = $this->Common_model->get_client_list();	
		$data['process_list'] = $this->Common_model->get_process_for_assign();
		$data["aside_template"] = $this->aside;
		$data["content_template"] = "dynamic_pop_up/form.php";
		$this->load->view('dashboard',$data);
	}
	public function delete($id){
		$user_fusion_id = get_user_fusion_id();
		$fetch_query = "SELECT fems_id from dynamic_pop_up where id=$id and deleted=0"; 
		$fetched_data = $this->Common_model->get_query_result_array($fetch_query);
		$fetched_data = reset($fetched_data);
		// var_dump($fetched_data['fems_id'],$user_fusion_id);die;
		if($fetched_data['fems_id'] == $user_fusion_id){
			$qSql = "UPDATE dynamic_pop_up
				 SET deleted = 1
				 WHERE id = $id";
		    $this->db->query($qSql);
		}
		redirect('dynamic_pop_up/show');
	}
}
?>