<?php
		defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Test extends CI_Controller {

   
    /////////////////////////////////////////////////////////////////////////////////////////////
    // INDEX PAGE
    /////////////////////////////////////////////////////////////////////////////////////////////
    
	 function __construct() {
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
				
	 }
	 
    public function index()
    {
	if(check_logged_in()){
		
		$id=check_logged_in();
		

		$mood=$this->db->query("SELECT Mood ('distressed') as dis,Mood ('sad') as sad,Mood ('satisfied') as sat,Mood ('joyful') as joy,Mood ('enthusiastic') as ent")->result();
		
		$is_global_access = get_global_access();
		$current_user = get_user_id();
		$ses_dept_id=get_dept_id();

		//organisation news

		if($is_global_access==1 ){
				$qSql="Select *, DATE_FORMAT(publish_date,'%m/%d/%Y') as publishDate from organisation_news where is_active=1 order by publish_date  desc";
				$data['get_org_news'] = $this->Common_model->get_query_result_array($qSql);
			}else{
				$qSql="Select *, DATE_FORMAT(publish_date,'%m/%d/%Y') as publishDate from organisation_news where is_active=1 and office_id in ('ALL','$user_office_id') order by publish_date desc";
				$data['get_org_news'] = $this->Common_model->get_query_result_array($qSql);
			}

			//announcement 

			if($is_global_access==1 ){
				$qSql="Select * from fems_announcement where is_active=1 order by id desc";
				$data['get_announcement_desc'] = $this->Common_model->get_query_result_array($qSql);
			}else{
				$qSql="Select * from fems_announcement where is_active=1 and office_id in ('ALL','$user_office_id') order by id desc";
				$data['get_announcement_desc'] = $this->Common_model->get_query_result_array($qSql);
			}

			//DOB

			$qSql="Select dob, DATE_FORMAT(dob, '%d') as b_date, DATE_FORMAT(dob, '%m') as b_month from signin where id='$current_user' ";
			$data['get_birthday'] = $this->Common_model->get_query_result_array($qSql);
			$data['get_birthday']=$data['get_birthday'][0]['dob'];

		// echo "<pre>";
		// print_r($data['get_birthday'][0]['dob']);
		// echo "</pre>";
		
		//  die;


		$createdby=$this->session->all_userdata();
		
		$id=$createdby['logged_in']['id'];
		
		$data['rcount']=$this->db->query("select count(added_by) as rcount from dfr_employee_referral where added_by='".$id."'")->result();
		
		
		$distressed=$mood[0]->dis;
		$sad=$mood[0]->sad;
		$satisfied=$mood[0]->sat;
		$joyful=$mood[0]->joy;		
		$enthusiastic=$mood[0]->ent;
		
		$data['Fusion_mood']=array($distressed,$sad,$satisfied,$joyful,$enthusiastic);

		$data['Kol_mood']=array(0,0,60,20,20);
		$this->load->view('test/Dashboard',$data);
	
	}
	}
	

	public function bookmarks(){
		
		$current_user = get_user_id();
		$url=$_POST['urlPage'];
		$time=time();
		$query=$this->db->query("SELECT url FROM bookmarks WHERE user_id='$current_user' AND url='$url'");
		$row_count=$query->num_rows();
		
		if($row_count!=0){
	
				$data = [
            		'time' => $time,
        		];
		        
		        $this->db->where('user_id', $current_user,'url',$url);
		        $this->db->update('bookmarks', $data);
				
			}
			else
			{
				$data = [
			            'url' => $url,
			            'icon'=>'',
			            'user_id' => $current_user,
			            'time' => $time
			        ];

        
		        $this->db->insert('bookmarks', $data);		
			}

			$query=$this->db->query("SELECT url FROM bookmarks WHERE user_id='$current_user'");
			$data=$query->result();
			echo json_encode($data);

	}

	public function browser_history(){
		
		$current_user = get_user_id();
		$CurPageURL=$_POST['URL'];
		$time=time();
		$query=$this->db->query("SELECT * FROM browser_history WHERE user_id='$current_user' AND url='$CurPageURL'");
		$row_count=$query->num_rows();
		$data=$query->result();		
		
		if($row_count!=0){

				
				$data = [
            		'time' => $time,
        		];
		        
		        $this->db->where('user_id', $current_user,'url',$CurPageURL);
		        $this->db->update('browser_history', $data);
				
				}
				else
				{						
					$data = [
			            'url' => $CurPageURL,
			            'user_id' => $current_user,
			            'time' => $time
			        ];

		        $this->db->insert('browser_history', $data);
		
				}

      $query = $this->db->query("SELECT DISTINCT url FROM browser_history WHERE user_id = '$current_user' ORDER BY time DESC LIMIT 10");

      $array = $query->result();
      echo json_encode($array);

  }

	public function dob(){

		$is_global_access = get_global_access();
		$current_user = get_user_id();
		$ses_dept_id=get_dept_id();

		$curr_date = date('m-d',strtotime(GetLocalTime()));
			
			//$next_date = date('m-d', strtotime(GetLocalTime() .' +1 day'));
									
			if($is_global_access==1){
				$qSql = "select fusion_id, fname, lname, office_id, dept_id,(Select shname from department d where d.id=s.dept_id) as dept_name from signin s where DATE_FORMAT(dob, '%m-%d') = '$curr_date' and status=1";
			}else if(get_role_dir()=="admin"){
				$qSql = "select fusion_id, fname, lname, office_id, dept_id,(Select shname from department d where d.id=s.dept_id) as dept_name from signin s where DATE_FORMAT(dob, '%m-%d') = '$curr_date' and office_id='$user_office_id' and status=1";
			}else{	
				$qSql = "select fusion_id, fname, lname, office_id, dept_id,(Select shname from department d where d.id=s.dept_id) as dept_name from signin s where DATE_FORMAT(dob, '%m-%d') = '$curr_date' and office_id='$user_office_id' and dept_id='$ses_dept_id' and status=1";
			}
			
		 $user_today_dob = $this->Common_model->get_query_result_array($qSql);

		 echo json_encode($user_today_dob);
		
	}
	
	}

?>