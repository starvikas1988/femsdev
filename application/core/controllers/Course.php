<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Course extends CI_Controller {
    
    /////////////////////////////////////////////////////////////////////////////////////////////
    // INDEX PAGE
    /////////////////////////////////////////////////////////////////////////////////////////////
    
	 public function __construct() {
		parent::__construct();
		$this->load->library('Php_office');
		$this->load->model('Common_model');
		$this->load->model('user_model');
		$this->load->model('Profile_model');	
	 }
	
	
    public function index()
    {
        if(check_logged_in()){ 
		
			
		     get_role_dir();
			 $current_user = get_user_id();
			 $user_site_id= get_user_site_id();
			 $user_role_id= get_role_id();
			 $user_office_id=get_user_office_id();
			 $ses_dept_id=get_dept_id();
			 $is_global_access=get_global_access();
			 $data['prof_pic_url']=  $this->Profile_model->get_profile_pic(get_user_fusion_id());
			 $data["content_js"] = "course/course_js.php";
			  
			 $SQLtxt = "SELECT * FROM course_assign_cordinator where user_id=". $current_user ."";
			 $data['course_categories'] = $this->Common_model->get_query_result_array($SQLtxt);
			 
			 $sql = "SELECT *,(select categories_name from course_categories where course_id = cac.category_id) as category_name,(select fusion_id from signin where id=cac.user_id)as fusionid ,(select concat(fname,' ',lname) from signin where id=cac.user_id) as cname FROM course_assign_cordinator cac";
			 $data['cordinator_detail'] = $this->Common_model->get_query_result_array($sql);
				
			 //$qSql = "SELECT id,fusion_id,concat(fname,' ',lname)as name FROM signin where role_id in (select id from role where folder in('manager','tl','trainer','hr') and signin.id NOT IN (SELECT user_id FROM course_assign_cordinator where category_id=1) and is_active=1)";
			/*  $qSql = "SELECT xx.id as id,xx.fusion_id as fusion_id ,concat(xx.fname,' ',xx.lname)as name,rr.folder FROM signin xx INNER JOIN 
						role rr on xx.role_id = rr.id where folder in('manager','tl','trainer','hr') AND office_id ='". $user_site_id ."'
						AND xx.id NOT IN (SELECT user_id FROM course_assign_cordinator where category_id=1) and is_active=1
						ORDER BY rr.folder"; */
						 
			$qSql = "SELECT xx.id as id,xx.fusion_id as fusion_id ,concat(xx.fname,' ',xx.lname)as name,rr.folder FROM signin xx INNER JOIN 
						role rr on xx.role_id = rr.id where folder in('manager','tl','trainer','hr')
						AND xx.id NOT IN (SELECT user_id FROM course_assign_cordinator) and is_active=1
						ORDER BY rr.folder";

			 $data['Cordinator_list'] = $this->Common_model->get_query_result_array($qSql); 
			 
				if(!empty($data['course_categories'])){
					if( $data['course_categories'][0]['user_id'] == $current_user){
						$this->session->set_userdata("gant_access",true);
					}else{
						$this->session->set_userdata("gant_access",false);
					}
				}else{
					$this->session->set_userdata("gant_access",false);
				}
				 
				if(get_role_dir()=="super" || get_role_dir()=="admin" || get_user_fusion_id() == 'FCEB000013' ||  get_user_fusion_id() == 'FKOL006655' || get_global_access() == 1) {
					
					$data["isAddCategories"] =1;
					$data["aside_template"] = "course/aside.php";
					$data["content_template"] = "course/course_gallery.php";
					$this->session->set_userdata("gant_access",true);
					$data['gant_access'] = $this->session->userdata("gant_access");
					
					$sql = "SELECT * FROM course_categories";
					$data['course_categories'] = $this->Common_model->get_query_result_array($sql);
					
					$this->load->view('dashboard',$data);
					
				}elseif($this->session->gant_access == true ){
					
					$data["isAddCategories"] =0;
					
					$data["aside_template"] = "course/aside.php";
					$data["content_template"] = "course/course_gallery.php";
					$data['gant_access'] = $this->session->userdata("gant_access");
					
					$sql = "SELECT * FROM course_categories INNER join course_assign_cordinator on course_categories.course_id = course_assign_cordinator.category_id where user_id= $current_user  AND course_status =1";
					$data['course_categories'] = $this->Common_model->get_query_result_array($sql); 
					
					$this->load->view('dashboard',$data);
					
				}elseif($this->session->gant_access == false){
				
					$data["content_template"] = "course/course_detail_new.php";
					$data['gant_access'] = $this->session->userdata("gant_access");
					
					$SQLtxt = "SELECT * FROM course_detail WHERE is_global =1 AND is_active =1";
					$course_global = $this->Common_model->get_query_result_array($SQLtxt);
					
					/* $SQLtxt = "SELECT * FROM course_detail WHERE is_global =1 AND is_active =0";
					$data['deactivated_course'] = $this->Common_model->get_query_result_array($SQLtxt); */
					
						 if(!empty($course_global)){
							 foreach($course_global as $global_files){
								 
								$SQLtxt = "SELECT * from course_assign_agents where category_id=". $global_files['categories_id']. " AND course_id=". $global_files['course_id'] ." AND agent_id=". $current_user ." AND is_active=1";
								$result =  $this->Common_model->get_query_row_array($SQLtxt);
								
								if(empty($result)){
									if(($global_files['is_global'] == 1) && ($global_files['categories_id'] != $result['category_id'])  && ($global_files['course_id'] !=  $result['course_id']) && ($current_user != $result['agent_id'])){
										
										/* $field_data = array("category_id"=>$global_files['categories_id'],
															"course_id"=>$global_files['course_id'],
															"agent_id"=>$current_user,
															"is_global"=>1); */
															
										$SQLtxt = "REPLACE INTO course_assign_agents(category_id,course_id,agent_id,is_global,is_active)VALUES(". $global_files['categories_id'] .",". $global_files['course_id'] .",". $current_user .",1,1)";					
										$this->db->query($SQLtxt);
										
										//$rowid = data_inserter('course_assign_agents',$field_data);
										//echo "NO P"; 
									
									}else{
										//echo "P";
									}
								}else{
									// echo "EMPTY 1";
								}
									//echo date('Y-m-d',strtotime($global_files['check_month_day']));
							} 
						}else{
							// echo "EMPTY 2";
						}
						
						
					
						$SQLtxt = "SELECT *,id,category_id as categories_id,course_id ,agent_id,(select CONCAT(fname,' ',lname) from signin INNER JOIN  course_detail ON signin.id = course_detail.created_by WHERE course_id = caa.course_id AND category_id = caa.category_id)as creator ,(select course_name from course_detail where course_id = caa.course_id AND category_id = caa.category_id) as course_name,(select course_desc from course_detail where course_id = caa.course_id AND category_id = caa.category_id) as course_desc,(select fusion_id from signin where id=caa.agent_id)as fusionid ,(select concat(fname,' ',lname) from signin where id=caa.agent_id) as cname FROM course_assign_agents caa where caa.agent_id=$current_user AND is_active=1";
						$data['course_details'] = $this->Common_model->get_query_result_array($SQLtxt); 
					
					
					$this->load->view('course_dashboard',$data);
					
				}
				 
		}
    }
	
	
	public function direct_access_course(){
		
		if(check_logged_in()){ 
			
			 $this->session->set_userdata("is_moderator",true);
			 $this->session->set_userdata("gant_access",false);
			 get_role_dir();
			 $current_user = get_user_id();
			 $user_site_id= get_user_site_id();
			 $user_role_id= get_role_id();
			 $user_office_id=get_user_office_id();
			 $ses_dept_id=get_dept_id();
			 $is_global_access=get_global_access();
			 $data['prof_pic_url']=  $this->Profile_model->get_profile_pic(get_user_fusion_id());
			 $data["content_js"] = "course/course_js.php";
			 
			 $SQLtxt = "SELECT * FROM course_assign_cordinator where user_id=". $current_user ."";
			 $data['course_categories'] = $this->Common_model->get_query_result_array($SQLtxt);
			 
			 $sql = "SELECT *,(select categories_name from course_categories where course_id = cac.category_id) as category_name,(select fusion_id from signin where id=cac.user_id)as fusionid ,(select concat(fname,' ',lname) from signin where id=cac.user_id) as cname FROM course_assign_cordinator cac";
			 $data['cordinator_detail'] = $this->Common_model->get_query_result_array($sql);
			
			
		
		           $data["content_template"] = "course/course_detail_new.php";
					$data['gant_access'] = $this->session->userdata("gant_access");
					
					$SQLtxt = "SELECT * FROM course_detail WHERE is_global =1 AND is_active =1";
					$course_global = $this->Common_model->get_query_result_array($SQLtxt);
					
						 if(!empty($course_global)){
							 foreach($course_global as $global_files){
								 
								$SQLtxt = "SELECT * from course_assign_agents where category_id=". $global_files['categories_id']. " AND course_id=". $global_files['course_id'] ." AND agent_id=". $current_user ." AND is_active=1";
								$result =  $this->Common_model->get_query_row_array($SQLtxt);
								
								if(empty($result)){
									if(($global_files['is_global'] == 1) && ($global_files['categories_id'] != $result['category_id'])  && ($global_files['course_id'] !=  $result['course_id']) && ($current_user != $result['agent_id'])){
										
										/* $field_data = array("category_id"=>$global_files['categories_id'],
															"course_id"=>$global_files['course_id'],
															"agent_id"=>$current_user,
															"is_global"=>1); */
															
										$SQLtxt = "REPLACE INTO course_assign_agents(category_id,course_id,agent_id,is_global,is_active)VALUES(". $global_files['categories_id'] .",". $global_files['course_id'] .",". $current_user .",1,1)";					
										$this->db->query($SQLtxt);
										
										//$rowid = data_inserter('course_assign_agents',$field_data);
										echo "NO P"; 
									
									}else{
										echo "P";
									}
								}else{
									// echo "EMPTY 1";
								}
									//echo date('Y-m-d',strtotime($global_files['check_month_day']));
							} 
						}else{
							// echo "EMPTY 2";
						}
						
						
					
						$SQLtxt = "SELECT *,id,category_id as categories_id,course_id ,agent_id,(select CONCAT(fname,' ',lname) from signin INNER JOIN  course_detail ON signin.id = course_detail.created_by WHERE course_id = caa.course_id AND category_id = caa.category_id)as creator ,(select course_name from course_detail where course_id = caa.course_id AND category_id = caa.category_id) as course_name,(select course_desc from course_detail where course_id = caa.course_id AND category_id = caa.category_id) as course_desc,(select fusion_id from signin where id=caa.agent_id)as fusionid ,(select concat(fname,' ',lname) from signin where id=caa.agent_id) as cname FROM course_assign_agents caa where caa.agent_id=$current_user AND is_active=1";
						$data['course_details'] = $this->Common_model->get_query_result_array($SQLtxt); 
					 
					$this->load->view('course_dashboard',$data);
					
		}
	}
	
	
	//// Create categories ///////
	
	public function create(){
		get_role_dir();
	    $current_user = get_user_id();
	    $user_site_id= get_user_site_id();
        $user_role_id= get_role_id();
	    $user_office_id=get_user_office_id();
	    $ses_dept_id=get_dept_id();
	    $is_global_access=get_global_access();
		$categories_id = $this->input->post('cate_id');
		$categories = $this->input->post('categories');
		$description = $this->input->post('description'); 
		$status = $this->input->post('status');
		
			if($this->input->post('submit') == 'SAVE'){
			
					if($categories_id == ''){
						
						$array_data = array('categories_name'=>$categories,
											'course_description'=>$description,
											'course_status' => $status,
											'created_by' => $current_user,
											'log'=> get_logs());
											
						$rowid = data_inserter('course_categories',$array_data);
						redirect('Course');
						
					}else{
						
						 $this->db->trans_start();
						 $this->db->query("UPDATE course_categories SET categories_name='". $categories ."',course_description='". $description ."' , course_status=". $status ."  WHERE course_id=". $categories_id ."");
						 $this->db->query("UPDATE course_detail SET is_active=". $status ."  WHERE categories_id=". $categories_id ."");
						 $this->db->query("UPDATE course_assign_agents SET is_active=". $status ."  WHERE category_id=". $categories_id ."");
						 if($this->db->trans_status === false){
						   $this->db->trans_rollback();
						 }else{
							$this->db->trans_complete();
						 }
						
						redirect('Course');
					}
					
			}elseif($this->input->post('submit') == 'SAVE_ASSIGN'){
					
					$categories = $this->input->post('course_categories');
					$cordinator = $this->input->post('cordinator');
					
					$array_data = array('category_id'=>$categories,
										'user_id'=>$cordinator,
										'assigned_by' => $current_user,
										'log'=> get_logs());

				   $rowid = data_inserter('course_assign_cordinator',$array_data);
				    
				    redirect('Course');
			} 
				
	}
	 
	public function get_categories(){
		if(check_logged_in()){
			$categories_id = $this->input->post('id');
			$SQLxt ="SELECT * from course_categories WHERE course_id=". $categories_id ."";
			$fields = $this->Common_model->get_query_result_array($SQLxt);
			
			echo json_encode($fields);
		}
	}
	 
	public function view_subject_list($categories_id,$is_subcategories=''){
		 if(check_logged_in()){
			
			 
			if($this->session->userdata('is_moderator') == true){
				$this->session->set_userdata("gant_access",true);
			}
			 
			
			$current_user = get_user_id();
			$user_site_id= get_user_site_id();
			$user_role_id= get_role_id();
			$user_office_id=get_user_office_id();
			$ses_dept_id=get_dept_id();
			$is_global_access=get_global_access(); 
			
				
				$data["aside_template"] = "course/aside.php";
				$data["content_template"] = "course/course_detail.php";  
 
  
				if(get_role_dir()=="super" || get_role_dir()=="admin" ||  get_global_access()=='1' || $this->session->userdata("gant_access") == 'true'){
						
						$data['gant_access'] = $this->session->userdata("gant_access");
						
						$sql = "SELECT *, course_id FROM course_detail where categories_id=". $categories_id ."";
						$data['course_details'] = $this->Common_model->get_query_result_array($sql);
						
						$sql = "SELECT * FROM lt_examination where type='CM'";
						$data['examination_list'] = $this->Common_model->get_query_result_array($sql);
						
						/* echo "<pre>";
						print_r($data['examination_list']); */
						/* $qSql = "SELECT id,fusion_id,concat(fname,' ',lname)as name FROM signin where  signin.id NOT IN (SELECT agent_id  FROM course_assign_agents where category_id= $categories_id)";
						$data['agent_list'] = $this->Common_model->get_query_result_array($qSql);  */
						 
				}else{
					$data['gant_access'] = $this->session->userdata("gant_access");
					redirect('Course'); 
				}
				
				 
			if($this->input->post('submit')== 'SAVE'){
				  $cid         = $this->input->post('cid');
				  $catid	   = $this->input->post('catid');
				  $is_global   = $this->input->post('global_field');
				  $course_name = $this->input->post('course_name');
				  $description = $this->input->post('description');
				  $is_active = $this->input->post('status');

					if($this->input->post('cid') == '' || $this->input->post('catid') == ''){
						
						$couse_name = $this->input->post('course_name');
						$couse_desc = $this->input->post('description');
						
							if($couse_name != '' && $couse_desc != ''){
								
								$array_data = array('course_name'=>$course_name,
													'course_desc'=>$description,
													'is_global'=>$is_global,
													'categories_id'=>$categories_id,
													'is_active'=>$is_active,
													'created_by'=>$current_user,
													'date_created'=> date('Y-m-d'),
													'log'=>get_logs());
												  
								$rowid = data_inserter('course_detail',$array_data);
							}
						
					}else{ 
					
						 $this->db->trans_start();
						 $SQLtxt = "UPDATE course_detail SET course_name='". $course_name ."',course_desc='". $description ."',is_global=". $is_global .",is_active=". $is_active .",date_created = '". date('Y-m-d') ."' WHERE course_id=". $cid ." AND categories_id=". $catid ."";
						 $this->db->query($SQLtxt);
						 
						 $SQLtxt = "UPDATE course_assign_agents SET is_active=". $is_active ." WHERE course_id=". $cid ." AND category_id=". $catid ."";
						 $this->db->query($SQLtxt);
						 
						 $SQLtxt1 = "DELETE FROM course_assign_agents WHERE category_id=". $categories_id ." AND course_id=". $cid ." AND is_global = 1";
						 $this->db->query($SQLtxt1);
						 
						 $SQLtxt2 = "DELETE FROM course_checkprogression WHERE category_id=". $categories_id ." AND course_id=". $cid ." AND user_id=". $current_user ."";
						 $this->db->query($SQLtxt2);
						 
						 
						 if($this->db->trans_status() === false){
						   $this->db->trans_rollback();
						 }else{
							$this->db->trans_complete();
						 } 
						
					}
						redirect('Course/view_subject_list/'.$categories_id);
				}  
			
			$this->load->view('dashboard',$data);
		}
	}
	
	
	public function view_courses($categories_id,$course_id){
		 if(check_logged_in()){
			$current_user = get_user_id();
			$user_site_id= get_user_site_id();
			$user_role_id= get_role_id();
			$user_office_id=get_user_office_id();
			$ses_dept_id=get_dept_id();
			$is_global_access=get_global_access();
			$is_access_content = false;
			$data['prof_pic_url']=  $this->Profile_model->get_profile_pic(get_user_fusion_id());
			
			
			if($this->session->userdata("gant_access") == true){
				
				$data["aside_template"] = "course/aside.php";
				$data["content_template"] = "course/course_uploads.php";
				$data['course_id'] 		= $course_id;
				$data['categories_id']  = $categories_id;
				
				$SQLtxt = "select * from course_filedetails where course_id=". $course_id ." AND categories_id=". $categories_id ." ";
				$data['get_files'] = $this->Common_model->get_query_result_array($SQLtxt); 
				$data['gant_access'] = $this->session->userdata("gant_access");					
				
				$SQLtxt = "Select * from course_detail where course_id=". $course_id ." AND categories_id = ". $categories_id ."";
				$data['course'] = $this->Common_model->get_query_result_array($SQLtxt);
				
				//$SQLtxt = "Select * from course_title cc INNER JOIN course_filedetails ff  on cc.title_id = ff.course_titleid AND cc.course_id = ff.course_id AND cc.category_id = ff.categories_id  WHERE  course_id=". $course_id ." AND category_id = ". $categories_id ."";
				$SQLtxt = "Select * from course_title   WHERE  course_id=". $course_id ." AND category_id = ". $categories_id ."";
				$data['course_title'] = $this->Common_model->get_query_result_array($SQLtxt);
				
				$SQLtxt = "SELECT * , (select lt_question_set.title from lt_question_set where lt_question_set.id = course_examination.allotted_set_id ) as set_title
								 from course_title
								 INNER JOIN course_examination ON 
								 course_title.title_id = course_examination.title_id
								 where course_examination.course_id=". $course_id ." AND course_examination.categories_id = ". $categories_id ."";

				$data['is_exam_assigned'] = $this->Common_model->get_query_result_array($SQLtxt);
				
				 
			
				$sql = "SELECT * FROM lt_examination where type='CM'";
				$data['examination_list'] = $this->Common_model->get_query_result_array($sql);

				$this->load->view('dashboard',$data);
				
			}elseif($this->session->userdata("gant_access") == false){
			
				
				$SQLtxt = "SELECT * FROM `course_assign_agents`  WHERE course_assign_agents.agent_id = ". $current_user ." AND course_assign_agents.course_id= ". $course_id . " AND course_assign_agents.category_id= ". $categories_id ."";
				$data['files_contents'] = $this->Common_model->get_query_result_array($SQLtxt);
				$data['category_id'] = $categories_id;
				$data['course_id'] = $course_id;
				$data['gant_access'] = false;
				
				$SQLtxt = "Select * from course_detail where course_id=". $course_id ." AND categories_id = ". $categories_id ."";
				$data['course'] = $this->Common_model->get_query_row_array($SQLtxt);
				
				$SQLtxt = "Select * from course_title where course_id=". $course_id ." AND category_id = ". $categories_id ."";
				$data['course_title'] = $this->Common_model->get_query_result_array($SQLtxt);
				
				
				$SQLtxt = "Select * from course_checkprogression where course_id=". $course_id ." AND category_id = ". $categories_id ." AND user_id=". $current_user ."";
				$data['check_progression'] = $this->Common_model->get_query_result_array($SQLtxt);
				 
				$SQLtxt ="SELECT * ,(select lt_question_set.exam_id from lt_question_set where lt_question_set.id = course_examination.allotted_set_id ) as exam_id, (select lt_question_set.title from lt_question_set where lt_question_set.id = course_examination.allotted_set_id ) as set_title from course_title INNER JOIN course_examination ON course_title.title_id = course_examination.title_id where course_examination.course_id=". $course_id ." AND course_examination.categories_id = ". $categories_id ."";
				$data['title_exam'] = $this->Common_model->get_query_result_array($SQLtxt);
				 
				if(!empty($data['title_exam'])){
					
					foreach($data['title_exam'] as $exam_id){
						$SQLtxt = "select * from course_lt_exam_schedule where exam_id = ". $exam_id['exam_id'] ." AND user_id=". $current_user ."";
						$data['exam_complete'] = $this->Common_model->get_query_result_array($SQLtxt);
					}
					
					
					 
				}

				
				//$data['check_course_iscomplete'] = "SELECT * FROM `course_title` LEFT JOIN course_checkprogression ON course_checkprogression.course_titleid=course_title.title_id where course_title.course_id=". $course_id ." AND course_title.category_id=". $categories_id ." AND course_title.user_id=". $current_user ."";
				  
					if($data['files_contents'][0]['is_view'] == 0){
						$data["aside_template"] = "course/aside.php";
						$data["content_template"] = "course/file_viewer_new.php";
						
						$this->load->view('dashboard_single_col',$data);
						
					}else{
						
						$data["aside_template"] = "course/qs_title.php";
					  //$data["content_template"] = "course/file_viewer.php";
						$data["content_template"] = "course/course_reader.php";
						$data["content_js"] = "course/course_js.php";
						 
						
						$this->load->view('course_dashboard',$data);
					}
				
				/* echo "<pre>";
				print_r($data['files_contents']);
				 */
				/*  if(!empty($data['files_contents'])){
					 if($data['files_contents'][0]['is_view'] == '0'){
						$_agentID 	  = get_user_id();
						$_category_id = $categories_id;
						$_course_id   = $course_id;
						
						$SQLtxt = "UPDATE course_assign_agents SET is_view=". 1 ."  where category_id=$_category_id AND course_id=$_course_id AND agent_id=$_agentID";
						$this->db->query($SQLtxt);
					 }else{
						
					 }
				 } */ 
				 
			}
			
			
		}
	}
	
	public function savedipcheck()
	{
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$user_office_id=get_user_office_id();
			$user_oth_office=get_user_oth_office();
			$is_global_access = get_global_access();
			$user_site_id= get_user_site_id();
			
			
			$log=get_logs();
			$evt_date=CurrMySqlDate();
			
			$set_id = trim($this->input->post('set_id'));			
			$module_id = trim($this->input->post('exam_id'));
			//$open_date = trim($this->input->post('open_date'));
			$open_date = date('Y-m-d');
			//$close_date = trim($this->input->post('close_date'));
			$close_date = date('Y-m-d', strtotime('+5 years'));
			$description = trim($this->input->post('description'));
			$categories_id = trim($this->input->post('categories_id'));
			$course_id = trim($this->input->post('course_id'));
			$title_id = trim($this->input->post('title_id'));
			$no_of_question  = trim($this->input->post('set_no_question'));
			$pass_marks  = trim($this->input->post('passmarks'));
			
			
			
			$timeDays = dateDiffCount($open_date, $close_date);
			$timeMinu= $timeDays*24*60;

			$field_array = array(
				"module_id"       => $module_id,
				"module_type"	  =>'CM',
				"allotted_time"   => $timeMinu,
				"allotted_set_id" => $set_id,
				"exam_id"       => $module_id,
				"course_id"     => $course_id,
				"categories_id" => $categories_id,
				"title_id" 		=> $title_id,
				"open_date"     => $open_date,
				"exam_start_time"=>$open_date,
				"close_date"    => $close_date,
				"description"   => $description,
				"exam_status"	=>0,
				"no_of_question"=>$no_of_question,
				"added_date"    =>  date('Y-m-d'),
				"added_by"      => $current_user,
				"added_time"    => $evt_date,
				"pass_marks"    => $pass_marks
			); 
			
			$SQLtxt ="SELECT * from course_examination where  course_id=". $course_id ." AND categories_id=". $categories_id ." AND title_id=". $title_id ."";
			$fields_data = $this->db->query($SQLtxt);
	 
			if($fields_data->num_rows() > 0){
				$this->db->trans_start(); 
				
				$qSql = 'SELECT exam_id as value  FROM lt_question_set WHERE id="'.$set_id.'"  and status=1 ORDER BY RAND() LIMIT 1';
				$exam_id=$this->Common_model->get_single_value($qSql);
				
				$qSql="SELECT count(id) as value FROM lt_questions where set_id = '$set_id' AND status = 1";
				$total_ques=$this->Common_model->get_single_value($qSql);
				
				
				$qSql = "UPDATE course_examination SET module_id='". $module_id ."', module_type='CM', allotted_time='".$timeMinu."',pass_marks=". $pass_marks .", allotted_set_id='".$set_id."', exam_start_time='".$open_date."', added_by='".$current_user."', added_date=now(), exam_status=0,no_of_question='".$no_of_question."' where  course_id=". $course_id ." AND categories_id=". $categories_id ." AND title_id=". $title_id ."";
				$query = $this->db->query($qSql);
				
				if ($this->db->trans_status() === FALSE) $this->db->trans_rollback();
				else $this->db->trans_commit();   
				
			}else{
				
			
				$this->db->trans_start(); 
				
				$rowid = data_inserter('course_examination',$field_array);
				
				/* $qSql = 'SELECT exam_id as value  FROM lt_question_set WHERE id="'.$set_id.'" and status=1 ORDER BY RAND() LIMIT 1';
				$exam_id=$this->Common_model->get_single_value($qSql);
				
				$qSql="SELECT count(id) as value FROM lt_questions where set_id = '$set_id' AND status = 1";
				$total_ques=$this->Common_model->get_single_value($qSql);
				
				$qSql = "UPDATE course_examination SET exam_id=". $exam_id .", module_type='CM', allotted_time='".$timeMinu."', allotted_set_id='".$set_id."', exam_start_time='".$open_date."', added_by='".$current_user."', added_date=now(), exam_status=0,no_of_question='".$no_of_question."' where id=". $rowid ."";
				$query = $this->db->query($qSql); */
				
				if ($this->db->trans_status() === FALSE) $this->db->trans_rollback();
				else $this->db->trans_commit(); 
			}
				
			
			 redirect(base_url()."/course/view_courses/".$categories_id.'/'.$course_id ,'refresh');
			
		}
	}
	
	public function set_selection(){
		$exam_id = $this->input->post('examid');
		
		if($exam_id != ''){
		   //$qSQLtxt = "SELECT * as value from lt_question_set WHERE exam_id=". $exam_id .""; 
		   $qSQLtxt = "SELECT *,COUNT(*)as value from lt_questions INNER JOIN lt_question_set ON lt_question_set.id = lt_questions.set_id WHERE lt_question_set.exam_id = ". $exam_id ." GROUP BY lt_question_set.id";
		   $fields_data = $this->Common_model->get_query_result_array($qSQLtxt); 
			
		   
			if(!empty($fields_data)){
				$fields_data['stat'] = true;
			}else{
				$fields_data['stat'] = false;
			}
			
		}else{
			$fields_data['stat'] = false;
		}
		
		echo json_encode($fields_data);
	}
	
	
	
	public function assign_users(){
		if(check_logged_in()){
			$current_user = get_user_id();
			$user_site_id= get_user_site_id();
			$user_role_id= get_role_id();
		    get_role();
			get_role_dir();
			/* print_r(get_process_ids());
			print_r(get_client_ids()); */
			
			$rr = $this->session->userdata('logged_in');
			
			$ses_office_id=get_user_office_id();
			$ses_dept_id=get_dept_id();
			
			$data['category_id'] = $this->uri->segment(3);
			$filter_id=1;

			$SQLtxt = "Select sd.id as sub_id,sd.name as sub_name,(Select office_name from office_location ol where ol.abbr = signin.office_id ) as office_name from sub_department sd INNER JOIN signin ON sd.id = signin.sub_dept_id where signin.id=". $current_user ."";
			$data['sub_department'] = $this->Common_model->get_query_row_array($SQLtxt); 
				
			$SQLtxt = "select infoac.client_id as client_id,(select shname from client where client.id = infoac.client_id)as client_name from info_assign_client infoac inner join signin xx on infoac.user_id = xx.id where xx.id=". $current_user ."";
			$data['client_details_list'] =  $this->Common_model->get_query_result_array($SQLtxt);
			
			
			$SQLtxt = "select  infoap.process_id as process_id,(select name from process where process.id = infoap.process_id) as process_name from info_assign_process infoap inner join signin xx on infoap.user_id =  xx.id where xx.id=". $current_user ."";
			$data['process_details_list'] =  $this->Common_model->get_query_result_array($SQLtxt);
			
			// SELECT ASSIGNED USER DETALIS FOR PERTICULAR CATEGORY
			
			$SQLtxt ="SELECT * from course_assign_agents inner JOIN course_detail on course_detail.course_id = course_assign_agents.course_id WHERE category_id= ". $data['category_id'] ."";
			$data['course_assigned_user'] = $this->Common_model->get_query_result_array($SQLtxt); 
			
			// SELECT ASSIGNED USER DETALIS FOR PERTICULAR CATEGORY
			
			$SQLtxt ="SELECT * from course_categories where course_id  = ". $data['category_id'] ."  AND course_status=1";
			$data['course_categories'] = $this->Common_model->get_query_row_array($SQLtxt); 
			
			
			$SQLtxt ="SELECT * from course_detail where categories_id  = ". $data['category_id'] ."  AND is_active=1";
			$data['course_detail'] = $this->Common_model->get_query_result_array($SQLtxt); 
			$data['gant_access'] = $this->session->userdata("gant_access");

 				
			$data["aside_template"] = "course/aside.php";			
			$data["content_template"] = "course/course_assign.php";
			   
					$dValue = $this->input->post('dept_id');
					
					if(!empty($dValue)){

						$dValue =  implode(',',$dValue);
					
					}
					
					$sdValue = trim($this->input->post('sub_dept_id'));
					if($sdValue == "") $sdValue = trim($this->input->post('sub_dept_id'));
					
					$cValue = trim($this->input->post('client_id'));
					if($cValue == "") $cValue = trim($this->input->post('client_id'));
					
					$oValue = $this->input->post('office_id');
					if($oValue == "") $oValue = $this->input->post('office_id');
					
				
					if(is_array($oValue)){
						if(!empty($oValue)){
							$i=0;
							$oValue1 ='';
							
								foreach($oValue as $val){
									
									if($i == 0){
										$oValue1 .=  "'". $oValue[$i] ."'";
									}else{
										$oValue1 .=  ",'". $oValue[$i] ."'";
									}
									$i++;
								}
								$oValue  = $oValue1 ;
							 
						}else{
							$oValue =  "'". $oValue ."'";
						}
					}else{
						$oValue =  "'". $oValue ."'";
					}
					
					$sValue = trim($this->input->post('site_id'));
					if($sValue=="") $sValue = trim($this->input->post('site_id'));
					//$sValue = "";
					
					$pValue = trim($this->input->post('process_id'));
					if($pValue=="") $pValue = trim($this->input->post('process_id'));
					
					$spValue = trim($this->input->post('sub_process_id'));
					if($spValue=="") $spValue = trim($this->input->post('sub_process_id'));
					
					$aValue = trim($this->input->post('assigned_to'));
					if($aValue=="") $aValue = trim($this->input->post('assigned_to'));
					
					$fusionid = trim($this->input->post('fusionid'));
					if($fusionid=="") $fusionid = trim($this->input->post('fusionid'));
					
					if($dValue=="") $dValue=$ses_dept_id;
					if($oValue=="") $oValue=$ses_office_id;
					
					$data['dValue']=$dValue;
					$data['sdValue']=$sdValue;
					$data['cValue']=$cValue;
					$data['oValue']=$oValue;
					$data['sValue']=$sValue;
					$data['pValue']=$pValue;
					$data['aValue']=$aValue;
					$data['spValue']=$spValue;
					$data['fusionid']=$fusionid;
					
					$_filterCond="";
					
					
					if($dValue!="ALL" && $dValue!="") $_filterCond .= " And dept_id in(". $dValue .")";
					if($sdValue!="ALL" && $sdValue!="") $_filterCond .= " And sub_dept_id='".$sdValue."'";
					
					//if($cValue!="ALL" && $cValue!="") $_filterCond .= " And client_id='".$cValue."'";
					if($cValue!="ALL" && $cValue!="") $_filterCond .= " And is_assign_client (b.id,$cValue)";
					
					if($oValue!="'ALL'" && $oValue!="") $_filterCond .= " And office_id in(".$oValue.")";
					if($sValue!="ALL" && $sValue!="") $_filterCond .= " And site_id='".$sValue."'";
					
					//if($pValue!="ALL" && $pValue!="") $_filterCond .= " And process_id='".$pValue."'";
					if($pValue!="ALL" && $pValue!="" && $pValue!="0") $_filterCond .= " And is_assign_process(b.id,$pValue)";
								
					if($aValue!="ALL" && $aValue!="") $_filterCond .= " And assigned_to='".$aValue."'";
					if($spValue!="ALL" && $spValue!="") $_filterCond .= " And sub_process_id='".$spValue."'";
					
					if($fusionid!=""){
						$fusionids = implode("','",explode(',', $fusionid));											
						if($_filterCond=="") $_filterCond .= "And fusion_id in ('".$fusionids."') ";
						else $_filterCond .= " And fusion_id in  ('".$fusionids."' )";
					}
					
					$qSql="Select id,name from master_term_type where is_active=1";
					$data['ttype_list'] = $this->Common_model->get_query_result_array($qSql);
					
					
					
					
					$data['site_list'] = $this->Common_model->get_sites_for_assign();
					
					$data['disp_list'] = $this->Common_model->get_event_for_assign();
					$data['tl_list'] = $this->Common_model->get_tls_for_assign2("");
					
					$data['location_list'] = $this->Common_model->get_office_location_list();
					$data['department_list'] = $this->Common_model->get_department_list();
					
					$data['sub_department_list'] = $this->Common_model->get_sub_department_list($dValue);
								
					$data['client_list'] = $this->Common_model->get_client_list();
					
					if($cValue=="" || $cValue=="ALL") $data['process_list'] = array(); // $this->Common_model->get_process_for_assign();
					else $data['process_list'] = $this->Common_model->get_process_list($cValue);
					
					if($pValue!="" && $pValue!="ALL" && $pValue!="0") $data['sub_process_list'] = $this->Common_model->get_sub_process_list($pValue);
					else $data['sub_process_list']=array();
 
					
					$data['filter_id'] = 1;
					
				
					$data['filter_id'] = $filter_id;
			
			if($filter_id==1){
				$mCond=" and role_id>0 ".$_filterCond;
				$data['user_list'] = $this->Common_model->get_user_list("All",$mCond);	
			}else if($filter_id==2){
				$mCond=" and role_id>0 ".$_filterCond;
				$data['user_list'] = $this->Common_model->get_user_list("ONLINE",$mCond);	
			}else{
				$mCond=" and role_id>0 and disposition_id =1 ".$_filterCond;
				$data['user_list'] = $this->Common_model->get_user_list("MIA",$mCond);
			}
	
	
	
			$qStrParam=$_SERVER["QUERY_STRING"];
			$data['qStrParam']=$qStrParam;
			
			 $data['qStrParam'];
 
 
			
			$this->load->view('dashboard',$data);
		}
	}
	
	
	public function assign(){
		if(check_logged_in()){
			$current_user = get_user_id();
			$category_id 		= $this->input->post('c_id');		
			$course_id   		= $this->input->post('course_id');
			$checkbox_userid    = $this->input->post('sel_uids'); 
			
			 if($this->input->post('Assign') == 'Assign_All'){
				
				 foreach($checkbox_userid as $userID){
					
					$SQLtxt = "REPLACE INTO course_assign_agents(category_id,course_id,agent_id,is_active,created_by,log)VALUES(". $category_id .",". $course_id .",". $userID .",1,". $current_user .",'". get_logs() ."')";
					$this->db->query($SQLtxt);
					
				 } 
				
			 }elseif($this->input->post('assign_single') == 'assign_single'){
				 
				   $SQLtxt = "REPLACE INTO course_assign_agents(category_id,course_id,agent_id,is_active,created_by,log)VALUES(". $category_id .",". $course_id .",". $checkbox_userid[0] .",1,". $current_user .",'". get_logs() ."')";
				   $this->db->query($SQLtxt);
					
			 }elseif($this->input->post('delete_single') == 'delete_single'){
				 
				   $SQLtxt = "DELETE FROM course_assign_agents WHERE category_id=". $category_id ." AND course_id=". $course_id ." AND agent_id=". $checkbox_userid[0] ."";
				   $SQLtxt = "DELETE FROM course_checkprogression WHERE category_id=". $category_id ." AND course_id=". $course_id ." AND user_id=". $checkbox_userid[0] ."";
				   $this->db->query($SQLtxt);
				   
			 }elseif($this->input->post('deassign') == 'deassign_all'){
					if(!empty($checkbox_userid)){
						$user_ids = implode(',',$checkbox_userid);
						$SQLtxt = "DELETE FROM course_assign_agents WHERE category_id=". $category_id ." AND course_id=". $course_id ." AND agent_id in(". $user_ids .")";
						$SQLtxt = "DELETE FROM course_checkprogression WHERE category_id=". $category_id ." AND course_id=". $course_id ." AND user_id in(". $user_ids .")";
						$this->db->query($SQLtxt);
					}
					
			 }else{
				 echo "Some error Occured....";
			 }
			 
			  redirect('course/assign_users/'.$category_id);	
		}
	}
	
	public function show_assigned_list(){
		if(check_logged_in()){
			
			$category_id = $this->input->get("cat");
			if($category_id != ''){
				$sql = "SELECT *,(select categories_name from course_categories where course_id = cac.category_id) as category_name,(select fusion_id from signin where id=cac.user_id)as fusionid ,(select concat(fname,' ',lname) from signin where id=cac.user_id) as cname FROM course_assign_cordinator cac where category_id=$category_id";
				$data['cordinator_detail'] = $this->Common_model->get_query_result_array($sql);
				
				echo json_encode($data['cordinator_detail']);
			}else{
				echo json_encode(array('error'=>""));
			}
		}
	}
	
	public function reload_cordinators(){
		if(check_logged_in()){
			$user_site_id= get_user_office_id();
			$category_id = $this->input->get("cat");
			
			if($category_id != ''){
				//$sql = "SELECT id,fusion_id,concat(fname,' ',lname)as name FROM signin where id in (select id from role where folder in('manager','tl','trainer') and id NOT IN (SELECT user_id FROM course_assign_cordinator where category_id=$category_id) and is_active=1 and status=1)";
				/* $sql = "SELECT xx.id as id,xx.fusion_id as fusion_id ,concat(xx.fname,' ',xx.lname)as name,rr.folder FROM signin xx INNER JOIN 
						role rr on xx.role_id = rr.id where folder in('manager','tl','trainer','hr') AND office_id ='". $user_site_id ."'
						AND xx.id NOT IN (SELECT user_id FROM course_assign_cordinator where category_id=". $category_id .") and is_active=1
						ORDER BY rr.folder"; */
						
				$sql = "SELECT xx.id as id,xx.fusion_id as fusion_id ,concat(xx.fname,' ',xx.lname)as name,rr.folder FROM signin xx INNER JOIN 
						role rr on xx.role_id = rr.id where folder in('manager','tl','trainer','hr') 
						AND xx.id NOT IN (SELECT user_id FROM course_assign_cordinator where category_id=". $category_id .") and is_active=1
						ORDER BY rr.folder";
						
				$data['cordinator_list'] = $this->Common_model->get_query_result_array($sql);
				
				echo json_encode($data['cordinator_list']);
			}else{
				echo json_encode(array('error'=>""));
			}
		}
	}
	
	public function delete_cordinator(){
		if(check_logged_in()){
			$msg='';
			
			$user_id = $this->input->get("id");
			
			if($user_id != ''){
				$SQLtxt = "DELETE fROM course_assign_cordinator WHERE id=". $user_id ."";
				$this->db->query($SQLtxt);

				 $msg = "User Deleted Sucessfully";
			}else{
				$msg='Something went wrong';
			}
			
			echo json_encode(array('msg' => $msg));
		}
	}

	// COURSE SECTION EXECUTION
	
	public function delete_agents(){
		if(check_logged_in()){
			$msg=''; 
			$id = $this->input->get("id");
			
				if($id != ''){
					$SQLtxt = "DELETE fROM course_assign_agents WHERE id=". $id ."";
					$this->db->query($SQLtxt);

					 $msg = "User Deleted Sucessfully";
				}else{
					 $msg = "Something Went Wrong";
				}
			
			echo json_encode(array('msg' => $msg));
		}
	}
	
	public function edit_course(){
		if(check_logged_in()){
			
			$course_id = $this->input->post("course_id");
			$category_id = $this->input->post("category_id");
			
			$SQLtxt = "SELECT * from course_detail where course_id=". $course_id ." AND categories_id =". $category_id ."";
			$data['course_list'] = $this->Common_model->get_query_result_array($SQLtxt);
			
			echo json_encode($data['course_list']);
			
		}
	}
	
	public function delete_course(){
		if(check_logged_in()){
			$msg='';
			$status='';
			
			$course_id = $this->input->post("course_id");
			$categories_id = $this->input->post("category_id");
			
			
			if($course_id != ''){
				/* $SQLtxt = "DELETE from course_detail where course_id= $course_id AND categories_id=". $categories_id ."";
				$this->db->query($SQLtxt); 
				
				$SQLtxt = "DELETE from course_assign_agents where course_id= $course_id AND category_id= $categories_id";
				$this->db->query($SQLtxt); 
				 
				$SQLtxt = "DELETE from course_checkprogression where course_id= $course_id AND category_id= $categories_id";
				$this->db->query($SQLtxt); 
				
				$SQLtxt = "DELETE from course_title where course_id= $course_id AND category_id= $categories_id";
				$this->db->query($SQLtxt);
				
				$SQLtxt = "DELETE course_lt_exam_schedule from course_lt_exam_schedule  INNER JOIN course_examination on   course_examination.title_id = course_lt_exam_schedule.title_id where   course_examination.course_id= $course_id AND course_examination.categories_id= $categories_id";
				$this->db->query($SQLtxt);
			 
				$SQLtxt = "DELETE from course_examination where course_id= $course_id AND categories_id= $categories_id";
				$this->db->query($SQLtxt); 
				 */
			 $msg = "Course Deleted Sucessfully";
			}else{
				
			}
			echo json_encode(array('status' => $status, 'msg' => $msg));
		}
	}
	
	public function delete_categories(){
		if(check_logged_in()){
			$msg='';
			$status='';
			
			$categories_id = $this->input->post("categories_id");
			if($categories_id != ''){
				
				/* $this->db->trans_start();
				$this->db->trans_strict(FALSE);

				$SQLtxt = "DELETE from course_assign_agents where category_id= $categories_id";
				$this->db->query($SQLtxt); 
				$SQLtxt = "DELETE from course_assign_cordinator where category_id= $categories_id";
				$this->db->query($SQLtxt); 
				$SQLtxt = "DELETE from course_categories where course_id= $categories_id";
				$this->db->query($SQLtxt); 
				$SQLtxt = "DELETE from course_checkprogression where category_id= $categories_id";
				$this->db->query($SQLtxt); 
				$SQLtxt = "DELETE from course_detail where categories_id= $categories_id";
				$this->db->query($SQLtxt); 
				$SQLtxt = "DELETE from course_examination where categories_id= $categories_id";
				$this->db->query($SQLtxt); 
				$SQLtxt = "DELETE from course_title where category_id= $categories_id";
				$this->db->query($SQLtxt);

				$this->db->trans_complete();

				if ($this->db->trans_status() === FALSE) {
					# Something went wrong.
					$this->db->trans_rollback();
					return FALSE;
				} 
				else {
					$this->db->trans_commit();
					return TRUE;
				} */
				
			 $msg = "Course Deleted Sucessfully";
			}else{
				
			}
			echo json_encode(array('status' => $status, 'msg' => $msg));
		}
	}
	
	 
	/* public function remove_global(){
		if(check_logged_in()){
			
			 $category_id = $this->input->post("catid");
			 $course_id   = $this->input->post("cid");
			 $is_global   = $this->input->post("global_field"); 
			 
			 if($is_global == 1){
				 $SQLtxt = "UPDATE course_detail SET is_global = 1 where course_id=". $course_id ." AND categories_id=". $category_id ."";
				 $this->db->query($SQLtxt);
			 }else{
				 $SQLtxt = "UPDATE course_detail SET is_global = 0 where course_id=". $course_id ." AND categories_id=". $category_id ."";
				 $this->db->query($SQLtxt);
			 }
			 
			 redirect('course/view_subject_list/'.$category_id);
		}
	} */
	
	
	
	//// exam 
	
	
	public function giveexam()
	{
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$user_office_id=get_user_office_id();
			$user_oth_office=get_user_oth_office();
			$is_global_access = get_global_access();
			$user_site_id= get_user_site_id();
			$data["is_global_access"] = get_global_access();
			
			$data["is_role_dir"] = get_role_dir();
			//$data['prof_pic_url']=$this->Profile_model->get_profile_pic(get_user_fusion_id());
			
			$data['aside_template'] = "course/aside.php";
			$data["content_template"] = "course/give_exam.php";
			$data["content_js"] = "course/give_exam_js.php";
			$data['gant_access'] = $this->session->userdata("gant_access");
			
			$data['categories_id'] = $this->input->post('categories_id');
			$data['course_id']   = $this->input->post('course_id');
			$data['title_id']   = $this->input->post('title_id');
			
			if(!empty($data['categories_id']) || !empty($data['course_id']) || !empty($data['title_id'])){
			 
				$SQLtxt = "select * from course_examination WHERE categories_id=". $data['categories_id'] ." AND course_id=". $data['course_id'] ." AND title_id=". $data['title_id'] ."";
				$data['field_data'] =  $this->Common_model->get_query_row_array($SQLtxt);
				
				if(!empty($data['field_data'])){
					
						$SQLtxt = "select * from course_lt_exam_schedule WHERE module_id=". $data['field_data']['module_id'] ." AND module_type='". $data['field_data']['module_type'] ."' AND user_id=". $current_user ." AND exam_id=". $data['field_data']['exam_id'] ." AND title_id=". $data['title_id'] ."";
						$check_field_data =  $this->db->query($SQLtxt);
					 	
						 if($check_field_data->num_rows() == 0){
							 
						 $data_field = array('module_id' => $data['field_data']['module_id'],
												'module_type' =>  $data['field_data']['module_type'],
												'user_id' => $current_user,
												'exam_id' => $data['field_data']['exam_id'],
												'allotted_time' => $data['field_data']['allotted_time'],
												'no_of_question' => $data['field_data']['no_of_question'],
												'allotted_set_id' => $data['field_data']['allotted_set_id'],
												'exam_start_time' => $data['field_data']['exam_start_time'],
												'title_id'        => $data['title_id'],
												'added_date' 	  => $data['field_data']['added_date'],
												'exam_status' 	  => $data['field_data']['exam_status'],
												'pass_marks' 	  => $data['field_data']['pass_mark']); 
												
							$rowid = data_inserter('course_lt_exam_schedule',$data_field); 
							
						}else{
							$SQLtxt = "UPDATE course_lt_exam_schedule set no_of_question=". $data['field_data']['no_of_question'] .",allotted_set_id=". $data['field_data']['allotted_set_id'] .",pass_marks= ". $data['field_data']['pass_mark'] ."   WHERE module_id=". $data['field_data']['module_id'] ." AND module_type='". $data['field_data']['module_type'] ."' AND user_id=". $current_user ." AND exam_id=". $data['field_data']['exam_id'] ." AND title_id=". $data['title_id'] ."";
							$this->db->query($SQLtxt);
							
						} 
					}else{
						echo "No Examination";
					}
				 
			
				//$qSql= 'SELECT course_lt_exam_schedule.*, getLocalToEst(course_lt_exam_schedule.exam_start_time,user_id) as exam_start_time_est,  NOW() AS current_server_time,(getLocalToEst(course_lt_exam_schedule.exam_start_time,user_id) + INTERVAL course_lt_exam_schedule.allotted_time MINUTE) AS exam_end_time FROM `course_lt_exam_schedule` WHERE user_id="'.$current_user.'" AND  (getLocalToEst(course_lt_exam_schedule.exam_start_time,user_id) - INTERVAL 30 MINUTE) <= NOW() AND (getLocalToEst(course_lt_exam_schedule.exam_start_time,user_id) + INTERVAL course_lt_exam_schedule.allotted_time MINUTE) >= now()';
				//$qSql='SELECT (select course_name from course_detail where course_detail.course_id = course_examination.course_id)as course_name,(select categories_id from course_detail where course_detail.course_id = course_examination.course_id)as category_id,(select course_id from course_detail where course_detail.course_id = course_examination.course_id)as course_id, course_lt_exam_schedule.*, getLocalToEst(course_lt_exam_schedule.exam_start_time,user_id) as exam_start_time_est, NOW() AS current_server_time,(getLocalToEst(course_lt_exam_schedule.exam_start_time,user_id) + INTERVAL course_lt_exam_schedule.allotted_time MINUTE) AS exam_end_time FROM `course_lt_exam_schedule` INNER JOIN course_examination on course_lt_exam_schedule.module_id = course_examination.module_id WHERE user_id=6462 AND (getLocalToEst(course_lt_exam_schedule.exam_start_time,user_id) - INTERVAL 30 MINUTE) <= NOW() AND (getLocalToEst(course_lt_exam_schedule.exam_start_time,user_id) + INTERVAL course_lt_exam_schedule.allotted_time MINUTE) >= now()';
			    
				$qSql="SELECT (select title from lt_examination WHERE lt_examination.id = course_examination.exam_id)as exam_title ,(select course_name from course_detail where course_detail.course_id = course_examination.course_id)as course_name,course_examination.categories_id,course_examination.course_id, course_lt_exam_schedule.* FROM course_lt_exam_schedule INNER JOIN course_examination on course_lt_exam_schedule.module_id = course_examination.module_id AND course_examination.title_id = course_lt_exam_schedule.title_id WHERE user_id='". $current_user ."'  AND course_examination.categories_id =". $data['categories_id'] ." AND course_examination.course_id=". $data['course_id'] ." AND course_examination.title_id=". $data['title_id'] ."";
				$get_alloted_set_query = $this->db->query($qSql);
				$get_alloted_set = $get_alloted_set_query->result_object();
				$data["available_exam"] = $get_alloted_set;
				
				if(!empty($data["available_exam"])){
					
					//echo $SQLtxt = "SELECT count(*),lt_questions.id, (title),text from course_lt_exam_schedule LEFT JOIN lt_questions ON course_lt_exam_schedule.allotted_set_id = lt_questions.set_id INNER JOIN lt_questions_ans_options on lt_questions_ans_options.ques_id = lt_questions.id INNER JOIN course_lt_user_exam_answer on course_lt_user_exam_answer.ques_id = lt_questions_ans_options.ques_id AND course_lt_user_exam_answer.ans_id = lt_questions_ans_options.id WHERE course_lt_exam_schedule.id = ". $data["available_exam"][0]->id ." AND lt_questions_ans_options.correct_answer=1";
					$SQLtxt = "SELECT count(*) as passed from course_lt_exam_schedule LEFT JOIN lt_questions ON course_lt_exam_schedule.allotted_set_id = lt_questions.set_id INNER JOIN lt_questions_ans_options on lt_questions_ans_options.ques_id = lt_questions.id INNER JOIN course_lt_user_exam_answer on course_lt_user_exam_answer.ques_id = lt_questions_ans_options.ques_id AND course_lt_user_exam_answer.ans_id = lt_questions_ans_options.id  AND course_lt_user_exam_answer.user_id=". $current_user ." WHERE course_lt_exam_schedule.id = ". $data["available_exam"][0]->id ." AND lt_questions_ans_options.correct_answer=1 AND course_lt_user_exam_answer.user_id=". $current_user ."";
					$data['correct_answer']  = $this->Common_model->get_query_result_array($SQLtxt);
					
					$SQLtxt = "SELECT count(*) as attempted from course_lt_exam_schedule LEFT JOIN lt_questions ON course_lt_exam_schedule.allotted_set_id = lt_questions.set_id INNER JOIN lt_questions_ans_options on lt_questions_ans_options.ques_id = lt_questions.id INNER JOIN course_lt_user_exam_answer on course_lt_user_exam_answer.ques_id = lt_questions_ans_options.ques_id AND course_lt_user_exam_answer.ans_id = lt_questions_ans_options.id AND course_lt_user_exam_answer.user_id=". $current_user ." WHERE course_lt_exam_schedule.id = ". $data["available_exam"][0]->id ." AND course_lt_user_exam_answer.user_id=". $current_user ."";
					$data['total_Attempted']  = $this->Common_model->get_query_row_array($SQLtxt);
				
					$total_no =0;
					if($data["available_exam"][0]->no_of_question == '' || $data["available_exam"][0]->no_of_question == 0){
						$total_no =0;
					}else{
						$total_no = (100 / $data["available_exam"][0]->no_of_question);
					}
					
					
					$total_correct = $data['correct_answer'][0]['passed'];
					$data['total_mark'] = ($total_no * $total_correct);
										
					if(($data['total_mark']) >= ($data['available_exam'][0]->pass_marks)){
						 $data['passed'] =1;
					}else{
						  $data['passed'] =0;
					}
				
				}
				
				
				$data["available_exam_count"] = $get_alloted_set_query->num_rows();
				
				$qSQLtxt ="SELECT (select course_name from course_detail where course_detail.course_id = course_examination.course_id)as course_name,course_examination.categories_id,course_examination.course_id, course_lt_exam_schedule_history.* FROM course_lt_exam_schedule_history INNER JOIN course_examination on course_lt_exam_schedule_history.module_id = course_examination.module_id AND course_examination.title_id = course_lt_exam_schedule_history.title_id WHERE user_id='". $current_user ."'  AND course_examination.categories_id =". $data['categories_id'] ." AND course_examination.course_id=". $data['course_id'] ." AND course_examination.title_id=". $data['title_id'] ."";
				$data['attempt_data'] = $this->Common_model->get_query_result_array($qSQLtxt);
				
				$this->load->view('dashboard',$data);
				
			}else{
				redirect('course'); 
			}
		}
	}
	
	//*******************************************************
	// NEW FUNCTION TO FETCH ATTEMPTED DATA //
	//*******************************************************
	
	public function get_exam_score(){
		
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_role_id= get_role_id();
		$user_office_id=get_user_office_id();
		$ses_dept_id=get_dept_id();
		$is_global_access=get_global_access();
		$is_access_content = false;
		$data['prof_pic_url']=  $this->Profile_model->get_profile_pic(get_user_fusion_id());
			
		$categories_id = $this->input->get('cid');
		$course_id     = $this->input->get('c_id');
		$title_id      = $this->input->get('tid');

		$data["content_template"] = "course/result_display.php";
		$data['aside_template'] = "course/aside.php";
		$data['gant_access'] = $this->session->userdata("gant_access");
		
		$qSQLtxt ="SELECT (select course_name from course_detail where course_detail.course_id = course_examination.course_id)as course_name,course_examination.categories_id,course_examination.course_id, course_lt_exam_schedule.* FROM course_lt_exam_schedule INNER JOIN course_examination on course_lt_exam_schedule.module_id = course_examination.module_id AND course_examination.title_id = course_lt_exam_schedule.title_id WHERE user_id='". $current_user ."'  AND course_examination.categories_id ='". $categories_id ."' AND course_examination.course_id='". $course_id ."' AND course_examination.title_id='". $title_id ."'";
		$data['attempt_data'] = $this->Common_model->get_query_row_array($qSQLtxt);

		/* echo "<pre>";
		print_r($data['attempt_data']); */
		
		$this->load->view('dashboard',$data);
		
	}
	
	
	
	public function exam_panel()
	{
		if(check_logged_in())
		{
				
			$form_data = $this->input->post();
			
			$current_user = get_user_id();
			$user_office_id=get_user_office_id();
			$user_oth_office=get_user_oth_office();
			$is_global_access = get_global_access();
			$user_site_id= get_user_site_id();
			$data['gant_access'] = $this->session->userdata("gant_access");
			
			$data["is_global_access"] = get_global_access();
			$data['aside_template'] = "course/aside.php";
			
			$data["is_role_dir"] = get_role_dir();
			
			$data["exam_schedule_id"] = $form_data['lt_exam_schedule_id'];
			$data['categories_id'] = $this->input->post('lt_exam_categories_id');
			$data['course_id'] = $this->input->post('lt_exam_course_id');
			$data['course_title'] = $this->input->post('course_title');
			
			if(!empty($data["exam_schedule_id"]) || !empty($data['categories_id']) || !empty($data['course_id'])){
				 
				$query_scheduled_exam = $this->db->query('SELECT * FROM `course_lt_exam_schedule` WHERE id='.$form_data['lt_exam_schedule_id'].' AND user_id="'. $current_user .'"');
				 
				$row = $query_scheduled_exam->row();
				
				$data["questions"] = $this->generate_question($row);
				
				$query_scheduled_exam = $this->db->query('SELECT * FROM `course_lt_exam_schedule` WHERE id='.$form_data['lt_exam_schedule_id'].'  AND user_id="'. $current_user .'"');
				$row = $query_scheduled_exam->row();
				$data["exam_info"] = $row;
				
				$data["content_template"] = "course/exam_panel.php";
				$data["content_js"] = "course/exam_panel_js.php";
				
				$this->load->view('dashboard',$data);
			}else{
				redirect('course');
			}
				
		}
	}
	
	private function generate_question($row)
	{
		$current_user = get_user_id();
		
		$question_info = array();
		
		//print_r($row);
		
		if($row->exam_status == 2 || $row->exam_status == 0 ){
						
			$query = $this->db->query('SELECT id FROM lt_questions WHERE set_id= "'.$row->allotted_set_id.'" ORDER BY RAND() LIMIT '.$row->no_of_question .'' );
			
			$this->db->query('DELETE FROM `course_lt_user_exam_answer` WHERE exam_schedule_id="'.$row->id.'" AND user_id="'. $current_user .'"');
			
			$rows = $query->result_object();
			$allotted_question_ids = array();
			$question_info = array();
			foreach($rows as $key=>$value){
				
				$allotted_question_ids[] = $value->id;
				$question_info['question_id'][] = $value->id;
				$question_info['question_status'][] = 0; 
				
				$this->db->query('INSERT INTO `course_lt_user_exam_answer`(`exam_schedule_id`,user_id, `ques_id`, `status`, `added_time`) VALUES ("'.$row->id.'","'. $current_user .'","'.$value->id.'","0",now())');
			}
			
			$this->db->query('UPDATE course_lt_exam_schedule SET exam_status="0",exam_start_time="'.ConvServerToLocal(date('Y-m-d H:i:s')).'" WHERE id='.$row->id.' AND user_id ="'. $current_user .'"');
			
		}else if($row->exam_status == 3){
			/* $minutes_to_add = $row->allotted_time;
			$time = new DateTime($row->exam_start_time);
			$time->add(new DateInterval('PT' . $minutes_to_add . 'M'));

			$end_time = $time->format('Y-m-d H:i:s');
			if(strtotime($end_time) < ConvServerToLocal(date('Y-m-d H:i:s')))
			{
				$this->db->query('UPDATE course_lt_exam_schedule SET exam_status="1" WHERE id='.$row->id.'');
				
				redirect('qa_dipcheck/qa_dashboard', 'refresh');
			}
			
			$qSql = 'SELECT lt_questions.id,course_lt_user_exam_answer.status FROM lt_questions INNER JOIN course_lt_user_exam_answer ON course_lt_user_exam_answer.ques_id=lt_questions.id WHERE set_id= "'.$row->allotted_set_id.'" and exam_schedule_id = "'. $row->id .'" ';
			
			//echo $qSql;
			
			$query = $this->db->query($qSql);
			
			$rows = $query->result_object();
			$allotted_question_ids = array();
			$question_info = array();
			foreach($rows as $key=>$value)
			{
				$allotted_question_ids[] = $value->id;
				$question_info['question_id'][] = $value->id;
				$question_info['question_status'][] = $value->status;
			} */
		}
		
		//print_r ($question_info);
		
		return $question_info;
		
	}
	
	public function get_first_question()
	{
		$current_user = get_user_id();
		$form_data = $this->input->post();
		
		$qSql = 'SELECT lt_questions.id,lt_questions.title,lt_questions_ans_options.id AS option_id,lt_questions_ans_options.text,lt_questions_ans_options.correct_answer,course_lt_user_exam_answer.status,course_lt_user_exam_answer.ans_id FROM lt_questions LEFT JOIN lt_questions_ans_options ON lt_questions_ans_options.ques_id=lt_questions.id
			LEFT JOIN course_lt_user_exam_answer ON course_lt_user_exam_answer.ques_id=lt_questions.id 
			WHERE lt_questions.id="'.$form_data['question_id'].'" AND exam_schedule_id="'.$form_data['exam_schedule_id'].'" AND course_lt_user_exam_answer.user_id="'. $current_user .'"';
		
		//echo $qSql;
	
		$query = $this->db->query($qSql);
		if($query)
		{
			$response['stat'] = true;
			$response['datas'] = $query->result_object();
		}
		else
		{
			$response['stat'] = false;
		}
		echo json_encode($response);
	}
	
	public function submit_question()
	{
		$current_user = get_user_id();
		$form_data = $this->input->post();
		$query = false;
		if($form_data['option_id'] != 0)
		{
			$query = $this->db->query('UPDATE course_lt_user_exam_answer SET ans_id="'.$form_data['option_id'].'",status="1"  WHERE exam_schedule_id="'.$form_data['exam_schedule_id'].'" AND ques_id="'.$form_data['question_id'].'" AND course_lt_user_exam_answer.user_id="'. $current_user .'"');
		}
		
		if($query)
		{
			$response['stat'] = true;
		}
		else
		{
			$response['stat'] = false;
		}
		echo json_encode($response);
	}
	public function get_question()
	{
		$current_user =  get_user_id();
		$form_data = $this->input->post();
		
		$query = $this->db->query('SELECT lt_questions.id,lt_questions.title,lt_questions_ans_options.id AS option_id,lt_questions_ans_options.text,lt_questions_ans_options.correct_answer,course_lt_user_exam_answer.status,course_lt_user_exam_answer.ans_id FROM lt_questions LEFT JOIN lt_questions_ans_options ON lt_questions_ans_options.ques_id=lt_questions.id
			LEFT JOIN course_lt_user_exam_answer ON course_lt_user_exam_answer.ques_id=lt_questions.id
			WHERE  course_lt_user_exam_answer.user_id="'. $current_user .'"  AND lt_questions.id="'.$form_data['question_id'].'" AND exam_schedule_id="'.$form_data['exam_schedule_id'].'"');
			
		if($query)
		{
			$response['stat'] = true;
			$response['datas'] = $query->result_object();
		}
		else
		{
			$response['stat'] = false;
		}
		echo json_encode($response);
	}
	
	public function submit_exam()
	{
		$current_user = get_user_id();
		$form_data = $this->input->post();
		//$query = false;
		
		$SQLtxt = "SELECT no_of_question,pass_marks from course_lt_exam_schedule WHERE course_lt_exam_schedule.id = ". $form_data['exam_schedule_id'] ."";
		$data['total_questions']  = $this->Common_model->get_query_row_array($SQLtxt);
		
		$SQLtxt = "SELECT count(*) as passed from course_lt_exam_schedule LEFT JOIN lt_questions ON course_lt_exam_schedule.allotted_set_id = lt_questions.set_id INNER JOIN lt_questions_ans_options on lt_questions_ans_options.ques_id = lt_questions.id INNER JOIN course_lt_user_exam_answer on course_lt_user_exam_answer.ques_id = lt_questions_ans_options.ques_id AND course_lt_user_exam_answer.ans_id = lt_questions_ans_options.id AND course_lt_user_exam_answer.user_id=". $current_user ." WHERE course_lt_exam_schedule.id = ". $form_data['exam_schedule_id'] ." AND lt_questions_ans_options.correct_answer=1 AND course_lt_user_exam_answer.user_id=". $current_user ."";
		$data['correct_answer']  = $this->Common_model->get_query_row_array($SQLtxt);
		
		$SQLtxt = "SELECT count(*) as attempted from course_lt_exam_schedule LEFT JOIN lt_questions ON course_lt_exam_schedule.allotted_set_id = lt_questions.set_id INNER JOIN lt_questions_ans_options on lt_questions_ans_options.ques_id = lt_questions.id INNER JOIN course_lt_user_exam_answer on course_lt_user_exam_answer.ques_id = lt_questions_ans_options.ques_id AND course_lt_user_exam_answer.ans_id = lt_questions_ans_options.id AND course_lt_user_exam_answer.user_id=". $current_user ."  WHERE course_lt_exam_schedule.id = ". $form_data['exam_schedule_id'] ." AND course_lt_user_exam_answer.user_id=". $current_user ."";
		$data['total_Attempted']  = $this->Common_model->get_query_row_array($SQLtxt);
	
			
		$total_no_qs      = (100 / $data['total_questions']['no_of_question']);
		$total_correct = $data['correct_answer']['passed'];
		$total_mark = ($total_no_qs * $total_correct);
		$data['total_questions']['pass_marks'];
		
		
		if(($total_mark) >= ($data['total_questions']['pass_marks'])){
			$this->db->query('UPDATE course_lt_exam_schedule SET exam_status="1",attempted_question="' . $data['total_Attempted']['attempted']  .'",correct_ans="'. $total_correct .'",scored="'. $total_mark.'"  WHERE id="'.$form_data['exam_schedule_id'].'" AND user_id="'. $current_user .'"');
		
		}else{
			$this->db->query('UPDATE course_lt_exam_schedule SET exam_status="0",attempted_question="' . $data['total_Attempted']['attempted'] .'",correct_ans="'. $total_correct .'",scored="'. $total_mark.'"   WHERE id="'.$form_data['exam_schedule_id'].'" AND user_id="'. $current_user .'"');
		}
		
		$query = $this->db->query('SELECT * FROM course_lt_exam_schedule WHERE id="'.$form_data['exam_schedule_id'].'"  AND user_id="'. $current_user .'"');
		$row = $query->row();
		
		
		//check if any more exam left
		$query1 = $this->db->query('SELECT COUNT(*) as available_exam FROM course_lt_exam_schedule WHERE module_id="'.$row->module_id.'" AND exam_status != 1  AND user_id="'. $current_user .'"');
		
		$results = $query1->row();
		
		$SQLtxt = "SELECT lt_question_set.exam_id,lt_questions.set_id,lt_questions_ans_options.ques_id,lt_questions_ans_options.id,lt_questions.title,lt_questions_ans_options.text FROM `lt_questions` INNER JOIN lt_questions_ans_options on lt_questions_ans_options.ques_id = lt_questions.id
					INNER JOIN course_lt_user_exam_answer ON lt_questions_ans_options.id = course_lt_user_exam_answer.ans_id
					INNER JOIN lt_question_set ON lt_question_set.id =lt_questions.set_id
					INNER JOIN course_lt_exam_schedule ON lt_question_set.id =course_lt_exam_schedule.allotted_set_id
					WHERE lt_questions_ans_options.correct_answer=1 AND course_lt_exam_schedule.id=". $form_data['exam_schedule_id'] ." AND course_lt_exam_schedule.user_id=". $current_user ."";
		
		$fields = $this->db->query($SQLtxt);

		$SQLtxt = "INSERT INTO course_lt_exam_schedule_history (title_id,module_id,module_type,user_id,exam_id,allotted_time,no_of_question,allotted_set_id,
					exam_start_time,exam_end_time,added_by,added_date,exam_status,pass_marks,attempted_question,correct_ans,scored) SELECT title_id,module_id,module_type,user_id,exam_id,allotted_time,no_of_question,allotted_set_id,
					exam_start_time,exam_end_time,added_by,added_date,exam_status,pass_marks,attempted_question,correct_ans,scored FROM course_lt_exam_schedule WHERE course_lt_exam_schedule.id=". $form_data['exam_schedule_id'] ."";
		$fields = $this->db->query($SQLtxt);
		
		if($query){
			$response['stat'] = true;
		}else{
			$response['stat'] = false;
		}
		echo json_encode($response);
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	

	
	
	public function upload()
	{
	 $filezip=array(); 
		if ( ! empty($_FILES)){
			$config['upload_path'] = "./course_uploads/";
			$config['allowed_types'] = 'gif|jpg|png|pdf|mp4';

			$this->load->library('upload');

			$files           = $_FILES;
			$number_of_files = count($_FILES['file']['name']);
			$errors = 0;
			
			 $id_categ		  = $this->input->post('id_categ');
			 $id_course 	  = $this->input->post('text');
			 $course_titleimg = $this->input->post('course_title');
			
			for ($i = 0; $i < $number_of_files; $i++)
			{
				
				
				$_FILES['file']['name'] = $files['file']['name'][$i];
				$_FILES['file']['type'] = $files['file']['type'][$i];
				$_FILES['file']['tmp_name'] = $files['file']['tmp_name'][$i];
				$_FILES['file']['error'] = $files['file']['error'][$i];
				$_FILES['file']['size'] = $files['file']['size'][$i];

				echo  $new_name = preg_replace('/\s+/','',$files['file']['name'][$i]);
				$config['file_name'] = $new_name; 
				unlink("/opt/lampp/htdocs/femsdev/course_uploads/" . $new_name);
				// we have to initialize before upload
				$this->upload->initialize($config);
			
				if (! $this->upload->do_upload("file")) { 
					$errors++;
				}else{
					   /*  $a = $this->input->post('id_categ');
						$b = $this->input->post('text');
						$course_titleimg = $this->input->post('course_title'); */
						
						/* $array_data = array('file_name'=>$new_name,
										'location'=>$new_name,
										'course_id'=>$b,
										'categories_id'=>$a,
										'course_titleid'=>$course_titleimg,
										); */
									 		
								 		
					//$rowid = data_inserter('course_filedetails',$array_data);
					
					$filezip[$i] = $new_name;
					
				}
			}
			
			$fileinto_string='';
			
			for($i=0; $i<count($filezip);$i++){
				if($i == (count($filezip) - 1)){
					$fileinto_string .= $filezip[$i];
				}else{
					$fileinto_string .= $filezip[$i].',';
				}
				
				$path_user ='/opt/lampp/htdocs/femsdev/course_uploads/';
				//echo $path_user = '/opt/lampp/htdocs/femsdev/course_uploads/'.$filezip[$i].'/';

				/* if (file_exists($path_user.$filezip[$i])){   
					 unlink($path_user.$filezip[$i]);
					 echo "true</br>";
				}else{
					 echo "false</br>";
				} */
			}
			
			
			
			
			
			$SQLtxt = "UPDATE course_title SET title_image='". $fileinto_string ."',is_text=0  WHERE course_id=". $id_course ." AND category_id=". $id_categ ." AND title_id=". $course_titleimg ."";
			$this->db->query($SQLtxt);
			
			
			if ($errors > 0){
				echo $errors . "File(s) cannot be uploaded";
			}

		}elseif ($this->input->post('file_to_remove')){
			$file_to_remove = $this->input->post('file_to_remove');
			$SQLtxt = "DELETE from course_filedetails where file_id=$file_to_remove";
			$this->db->query($SQLtxt);
			unlink("./course_uploads/" . $file_to_remove);	
		} 
	}

	public function listFiles(){
		$id_course = $this->input->get('text');
	    $SQLtxt = "Select * from course_title where course_id=". $id_course ."";
		$files = $this->Common_model->get_query_result_array($SQLtxt);
		
		
		
		echo json_encode($files);
	}
   
   
   public function load_files($course_id){
	   if(check_logged_in()){
		   $SQLtxt = "Select * from course_filedetails where course_id = " &  $course_id & "";
		   $files = $this->Common_model->get_query_result_array($SQLtxt);
	   }
   }
 
   public function mark_complete($categories_id,$course_id){
	   if(check_logged_in()){
			$_agentID 	  = get_user_id();
			$_category_id = $categories_id;
			$_course_id   = $course_id;
			
			$SQLtxt = "UPDATE course_assign_agents SET is_complete=". 1 ."  where category_id=$_category_id AND course_id=$_course_id AND agent_id=$_agentID";
			$this->db->query($SQLtxt);
			
			redirect('course');
		}		
   } 
   
   public function set_rules(){
	   if(check_logged_in()){
			
			$current_date = date("Y-m-d");
			 
			$cid_rules   = $this->input->post('cid_rules');
			$catid_rules = $this->input->post('catid_rules');
			$checkRules      = $this->input->post('expiry');
			$months      = $this->input->post('months'); 
			$prelim      = $this->input->post('prelim');
			 
			 
			if($checkRules == 'N'){
				$SQLtxt = "UPDATE course_detail SET rule_set=0,rules_type='". $checkRules ."', check_month_day='0000-00-00' WHERE course_id=". $cid_rules ." AND categories_id=". $catid_rules ."";
			}elseif($checkRules == 'M'){
				 $effectiveDate = date('Y-m-d', strtotime("+". $months ." months", strtotime($current_date)));
				 
				echo $SQLtxt = "UPDATE course_detail SET rule_set=1,rules_type='". $checkRules ."' , check_month_day='". $effectiveDate ."' WHERE course_id=". $cid_rules ." AND categories_id=". $catid_rules ."";
			}elseif($checkRules == 'C'){
				$SQLtxt = "UPDATE course_detail SET rule_set=1,rules_type='". $checkRules ."', check_month_day='0000-00-00'  WHERE course_id=". $cid_rules ." AND categories_id=". $catid_rules ."";
			}elseif($checkRules == 'P'){
				 $effectiveDate = date('Y-m-d', strtotime("+". $prelim ." days", strtotime($current_date)));
				$SQLtxt = "UPDATE course_detail SET rule_set=1,rules_type='". $checkRules ."' , check_month_day='". $effectiveDate ."' WHERE course_id=". $cid_rules ." AND categories_id=". $catid_rules ."";
			}
			
			$this->db->query($SQLtxt);
			
			redirect('course/view_subject_list/'.$catid_rules);
	   }
   }
	
   public function get_course_examination(){
	   if(check_logged_in()){
		   
		   $categories_id = $this->input->post('category_id');
		   $course_id = $this->input->post('course_id');
		   
		   $SQLtxt ="Select * from course_examination WHERE categories_id=". $categories_id ." AND course_id=". $course_id ."";
		   $array_data = $this->Common_model->get_query_result_array($SQLtxt);
		   
		   if(!empty($array_data)){
			   echo json_encode($array_data);
		   }else{
			   echo json_encode(array('null'=>0));
		   }
		   
	   }
   }
   
   
   public function create_description(){
	   if(check_logged_in()){
		   
		  $category_id    = $this->input->post('category_id');
		  $course_id      = $this->input->post('course_id');
		  $requirement    = trim($this->input->post('requirementFormControlInput1'));
		  $description    = trim($this->input->post('descriptionFormControlInput2'));
		  $prerequisites  = trim($this->input->post('prerequisitesFormControlInput3'));
		  $whoshouldForm  = trim($this->input->post('whoshouldFormControlInput4'));
		  $whosforForm    = trim($this->input->post('whosforFormControlInput5'));
		  
		  $SQLtxt ="UPDATE course_detail SET requirement='". htmlspecialchars ($requirement) ."',course_desc='". htmlspecialchars ($description) ."',prerequisites='". htmlspecialchars ($prerequisites) ."',whoshould='". htmlspecialchars ($whoshouldForm) ."',whosfor='". htmlspecialchars ($whosforForm) ."',language='English' WHERE course_id=". $course_id ." AND categories_id=". $category_id ."";
		  $this->db->query($SQLtxt);
		  
		  redirect('course/view_courses/'.$category_id.'/'.$course_id); 
		   
	   }
   }
   
  public function create_title(){
	   if(check_logged_in()){
		   
		  $category_id = $this->input->post('category_id');
		  $course_id   = $this->input->post('course_id');
		  $title_id    = $this->input->post('title_id');
		  $title       = $this->input->post('content');
		  
		 // $requirement = $this->input->post('requirement');
		 // $description = 'https://img-a.udemycdn.com/course/240x135/3057290_6754_2.jpg';
		 // 
		   
		   if($title_id == ''){
			   $data_array = array('course_id'=>$course_id,
								   'category_id'=>$category_id,
								   'title'=>$title);
			   
			   $rowid = data_inserter('course_title',$data_array);
		   }else{
			   
			   $SQLtxt = "UPDATE course_title SET title='". $title ."'  WHERE title_id=". $title_id ." AND course_id=". $course_id ." AND category_id=". $category_id ."";
			   $this->db->query($SQLtxt);
		   }
		   
		   redirect('course/view_courses/'.$category_id.'/'. $course_id);
		    
	   }
   }
   
   public function edit_title(){
	   if(check_logged_in()){
		   
		  $category_id = $this->input->post('categid');
		  $course_id   = $this->input->post('courseid');
		  $title_id    = $this->input->post('title_id');
		  
		  $SQLtxt = "SELECT * FROM course_title WHERE title_id=". $title_id ." AND course_id=". $course_id ." AND category_id=". $category_id ."";
		  $array_data = $this->Common_model->get_query_row_array($SQLtxt);
		   
		   if(!empty($array_data)){
			   echo json_encode($array_data);
		   }else{
			   echo json_encode(array('msg'=>'No record found'));
		   }
		  
	   }
   }
   
   public function delete_title(){
	   if(check_logged_in()){
		   
		  $category_id = $this->input->post('category_id');
		  $course_id   = $this->input->post('course_id');
		  $title_id    = $this->input->post('title_id');
		  
		  
		  $SQLtxt = "SELECT * FROM course_title WHERE is_text=0 AND title_id=". $title_id ." AND course_id=". $course_id ." AND category_id=". $category_id ."";
		  $array_data = $this->Common_model->get_query_row_array($SQLtxt);
	
		  
		  $files = '';
		  $path  = '/opt/lampp/htdocs/femsdev/course_uploads/';
		  
		  if(!empty($array_data)){
			  $files = $array_data['title_image'];
			  
			  $files_list = explode(',',$files);
			  
			  foreach($files_list as $file_name){
				  if(!is_dir($path . $file_name)){
						unlink($path . $file_name);
				  }
			  }
		  }
			  
		  
		  $SQLtxt = "DELETE FROM course_title WHERE title_id=". $title_id ." AND course_id=". $course_id ." AND category_id=". $category_id ."";
		  $this->db->query($SQLtxt);
		  
		   echo json_encode(array('msg'=>'Title Deleted Sucessfully'));
		   
		 
	   }
   }
   
   
     public function getassigned_exam(){
	   if(check_logged_in()){
		   
		  $category_id = $this->input->post('categid');
		  $course_id   = $this->input->post('courseid');
		  $title_id    = $this->input->post('title_id');
		  
		  //$SQLtxt = "SELECT * FROM course_title WHERE title_id=". $title_id ." AND course_id=". $course_id ." AND category_id=". $category_id ."";
		  //$array_data = $this->Common_model->get_query_row_array($SQLtxt);
		  $SQLtxt ="SELECT * FROM course_examination WHERE categories_id=". $category_id ." AND course_id=". $course_id  ." AND title_id=". $title_id  .""; 
		  $array_data = $this->Common_model->get_query_row_array($SQLtxt);
		  
		  
		   if(!empty($array_data)){
			   echo json_encode($array_data);
		   }else{
			   echo json_encode(array('msg'=>'No record found'));
		   }
		  
	   }
   }
   
   /////// dueeeeeeeee 
   public function inputtext(){
	   if(check_logged_in()){
		  $textform    = trim($this->input->post('inputtext'));
		  
		   $SQLtxt = "UPDATE course_title SET title='". $title ."'  WHERE title_id=". $title_id ." AND course_id=". $course_id ." AND category_id=". $category_id ."";
		   $this->db->query($SQLtxt);
	   }
   }
   
   public function enroll_now($_category_id,$_course_id){
	   if(check_logged_in()){
		   
		   $_agentID 	 = get_user_id();
		   
		   $SQLtxt = "UPDATE course_assign_agents SET is_view=". 1 ."  where category_id=$_category_id AND course_id=$_course_id AND agent_id=$_agentID";
		   $this->db->query($SQLtxt);
		   
		   redirect('course/view_courses/'.$_category_id.'/'. $_course_id);
	   }
   }
   
   
   public function check_progression(){
	   if(check_logged_in()){
		   
		   $checkstatus = $this->input->post('checkstatus');
		   $current_user = get_user_id();
		   $category_id = $this->input->post('category_id');
		   $course_id = $this->input->post('course_id');
		   $checkbox = $this->input->post('checkbox');
		   
		   if($checkstatus == 1){
			   
			   $SQLtxt ="REPLACE INTO course_checkprogression(user_id,course_id,category_id,course_titleid,date_completed)values(". $current_user .",". $course_id .",". $category_id .",". $checkbox .",now())";
			   $this->db->query($SQLtxt);
		   }else{
			   $SQLtxt ="DELETE FROM course_checkprogression WHERE user_id=". $current_user ." AND course_id=". $course_id ." AND category_id=". $category_id ." AND course_titleid=". $checkbox ."";
			   $this->db->query($SQLtxt);
		   }
	   }
   }

   public function create_textinsteadofimage(){
	   if(check_logged_in()){
		   
			$categories_id = $this->input->post('category_id');
			$course_id     = $this->input->post('course_id');
			$title_id      = $this->input->post('title_id');
			$bulktext      = $this->input->post('inputtext');
			
			$SQLtxt = "SELECT * from course_title WHERE category_id=". $categories_id ." AND course_id=". $course_id ." AND title_id=". $title_id ."";
			$array_data = $this->Common_model->get_query_row_array($SQLtxt);
			
			if(!empty($array_data)){
				$SQLtxt ="UPDATE course_title SET is_text=1,text_field='". $bulktext ."',title_image=''  WHERE category_id=". $categories_id ." AND course_id=". $course_id ." AND title_id=". $title_id ."";
				$this->db->query($SQLtxt);
				
			}else{
				$array_data = array ('category_id'=>$categories_id,
				 'course_id'=>$course_id,
				 'title_id'=>$title_id,
				 'text_field'=>$bulktext,
				 'is_text'=>1
				);
								
		   		$rowid = data_inserter('course_title',$array_data);		
			}
			
			redirect('course/view_courses/'.$categories_id.'/'. $course_id);
		
			
       }
   }
   
  public function sample_download(){
	  if(check_logged_in()){ 
		$file_name = base_url()."course_uploads/sample/Sample_examination.xlsx";
		header("location:".$file_name);	
		exit();
	  }
   }
   
   public function reporting($categid='',$course_id=''){
	   if(check_logged_in()){
		   
			$data["aside_template"] = "course/aside.php";
			$data["content_template"] = "course/reporting.php";
			$data['gant_access'] = $this->session->userdata("gant_access");
			$data['categ_id'] = $categid;
			$data['course_id'] = $course_id;
			
			$condition='';
			if($course_id != ''){
				$condition = "AND course_id = ". $course_id;
			}
			
			$SQLtxt = "SELECT * from course_detail where categories_id = ". $categid ."";
			$data['course_list'] = $this->Common_model->get_query_result_array($SQLtxt); 
			
			$SQLtxt = "SELECT count(*) as total_assigned from course_assign_agents where category_id = ". $categid ." ". $condition ."";
			$data['total_assigned'] = $this->Common_model->get_query_row_array($SQLtxt); 
			
			$SQLtxt = "SELECT count(*) as user_viewed from course_assign_agents where category_id = ". $categid ."  ". $condition ."";
			$data['total_user_viewed'] = $this->Common_model->get_query_row_array($SQLtxt); 
			
			$SQLtxt = "SELECT count(*) as user_completed from course_assign_agents where category_id = ". $categid ." ". $condition ."";
			$data['total_user_completed'] = $this->Common_model->get_query_row_array($SQLtxt); 
			$data['cat'] = '';
			
			if($this->input->post('assigned') == 'A'){
				$SQLtxt = "SELECT *,(SELECT description FROM department WHERE department.id = signin.dept_id) as department_name,(select fusion_id from (SELECT * from signin) x where x.id = signin.assigned_to) as assigned_to_fusionid,(select concat(fname,' ',lname) from (SELECT * from signin) x where x.id = signin.assigned_to) as assigned_to,(select course_name FROM course_detail WHERE course_detail.course_id = course_assign_agents.course_id)as course_name,(select  (fusion_id)  from signin where course_assign_agents.agent_id = signin.id)as fusionid,(select  concat(fname,' ',lname)  from signin where course_assign_agents.agent_id = signin.id)as name from course_assign_agents INNER JOIN signin on course_assign_agents.agent_id = signin.id where category_id = ". $categid ." ". $condition ."";
				$data['assigned_users'] = $this->Common_model->get_query_result_array($SQLtxt); 
				$data['cat'] = 'A';
				
			}elseif($this->input->post('examination') == 'E'){
				if($course_id != ''){
					$SQLtxt ="Select *,(SELECT description FROM department WHERE department.id = signin.dept_id) as department_name,(select fusion_id from (SELECT * from signin) x where x.id = signin.assigned_to) as assigned_to_fusionid,(select concat(fname,' ',lname) from (SELECT * from signin) x where x.id = signin.assigned_to) as assigned_to,(select course_name  from course_detail where category_id = ". $categid ." ". $condition ." ) as course_name,(select title from lt_question_set where lt_question_set.id = course_lt_exam_schedule_history.allotted_set_id) as set_name,(select concat(fname,' ',lname) from signin where signin.id = course_lt_exam_schedule_history.user_id)as username,if(course_lt_exam_schedule_history.scored >= course_lt_exam_schedule_history.pass_marks,1,0)as passed,(select description from course_examination where course_examination.module_id = course_lt_exam_schedule_history.module_id  AND course_examination.title_id = course_lt_exam_schedule_history.title_id )as description,(select fusion_id from signin WHERE course_lt_exam_schedule_history.user_id = signin.id)as fusionid from course_lt_exam_schedule_history INNER JOIN course_title ON course_title.title_id = course_lt_exam_schedule_history.title_id
							 INNER JOIN signin ON signin.id = course_lt_exam_schedule_history.user_id where category_id = ". $categid ." ". $condition ." order by  course_lt_exam_schedule_history.id desc";
							  
					$data['assigned_users'] = $this->Common_model->get_query_result_array($SQLtxt); 
					$data['cat'] = 'E';
				}else{
					redirect('course/reporting/'. $categid .'?error=1',"refresh");
				}
			} 

			
			
		    
			if($this->input->post('export') == 'A'){
				$SQLtxt = "SELECT *,(SELECT description FROM department WHERE department.id = signin.dept_id) as department_name,(select fusion_id from (SELECT * from signin) x where x.id = signin.assigned_to) as assigned_to_fusionid,(select concat(fname,' ',lname) from (SELECT * from signin) x where x.id = signin.assigned_to) as assigned_to,(select course_name FROM course_detail WHERE course_detail.course_id = course_assign_agents.course_id)as course_name,(select  (fusion_id)  from signin where course_assign_agents.agent_id = signin.id)as fusionid,(select  concat(fname,' ',lname)  from signin where course_assign_agents.agent_id = signin.id)as name, 
				(SELECT course_lt_exam_schedule_history.exam_start_time FROM course_lt_exam_schedule_history WHERE course_lt_exam_schedule_history.title_id IN (SELECT title_id from course_title WHERE course_title.category_id = ". $categid ." AND course_title.course_id=".$course_id.") AND course_lt_exam_schedule_history.user_id = course_assign_agents.agent_id ORDER BY course_lt_exam_schedule_history.id DESC LIMIT 1) as exam_start_time
				from course_assign_agents INNER JOIN signin on course_assign_agents.agent_id = signin.id  where category_id = ". $categid ." ". $condition ."";
				$assigned_users = $this->Common_model->get_query_result_array($SQLtxt); 
			 
				$this->export_excel($assigned_users,'A');
				
			}elseif($this->input->post('export') == 'E'){
				if($course_id != ''){
					$SQLtxt ="Select *,(SELECT description FROM department WHERE department.id = signin.dept_id) as department_name,(select fusion_id from (SELECT * from signin) x where x.id = signin.assigned_to) as assigned_to_fusionid,(select concat(fname,' ',lname) from (SELECT * from signin) x where x.id = signin.assigned_to) as assigned_to,(select course_name  from course_detail where category_id = ". $categid ." ". $condition ." ) as course_name,(select title from lt_question_set where lt_question_set.id = course_lt_exam_schedule_history.allotted_set_id) as set_name,(select concat(fname,' ',lname) from signin where signin.id = course_lt_exam_schedule_history.user_id)as username,if(course_lt_exam_schedule_history.scored >= course_lt_exam_schedule_history.pass_marks,1,0)as passed,(select description from course_examination where course_examination.module_id = course_lt_exam_schedule_history.module_id  AND course_examination.title_id = course_lt_exam_schedule_history.title_id )as description,(select fusion_id from signin WHERE course_lt_exam_schedule_history.user_id = signin.id)as fusionid from course_lt_exam_schedule_history INNER JOIN course_title ON course_title.title_id = course_lt_exam_schedule_history.title_id
							 INNER JOIN signin ON signin.id = course_lt_exam_schedule_history.user_id where category_id = ". $categid ." ". $condition ." order by  course_lt_exam_schedule_history.id desc";
							  
					$assigned_users = $this->Common_model->get_query_result_array($SQLtxt); 
					
					$this->export_excel($assigned_users,'E');
				}else{
					redirect('course/reporting/'. $categid . '?error=1' ,"refresh");
				}
			}
			
			  
			$this->load->view('dashboard',$data);
		   
	   }
   }
   
   

   
   public function export_excel($data_excel,$catgories){
	   if(check_logged_in()){ 
		   
		   $this->load->library('excel');
			 
		   $objPHPExcel = new PHPExcel(); 
		   $objPHPExcel->setActiveSheetIndex(0);
			//Set Title
		    $objPHPExcel->getActiveSheet()->setTitle($catgories == 'A'?'Assigned Users':'Examination');
		  
		   $row = 2;
		   $col = 0;
		   
		   if($catgories == 'A'){
			   
			   $objPHPExcel->getActiveSheet()->getStyle('A1:J1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('008000');
			   $objPHPExcel->getActiveSheet()->getStyle("A1:J1")->applyFromArray(
									array(
										'borders' => array(
											'allborders' => array(
												'style' => PHPExcel_Style_Border::BORDER_THIN,
												'color' => array('rgb' => '000000')
											)
										)
									)
								);
								
				$objPHPExcel->getActiveSheet()->getStyle("A1:J1")->getFont()->setBold(true)
                                ->setName('Verdana')
                                ->setSize(10)
                                ->getColor()->setRGB('ffffff');				
			   
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1,'Fusion ID');
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 1,'Agent Name');
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 1,'Department');		
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, 1,'Location');
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, 1,'Assigned To FID');
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, 1,'Assigned TO');
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, 1,'Course Name');
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, 1,'Is View');
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, 1,'Is Completed');
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, 1,'Date of Completion');
						
						$colstr='A';
						foreach ($data_excel as $field)
						{
							$objPHPExcel->getActiveSheet()->getColumnDimension($colstr++)->setAutoSize(true);
	
							$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $field['fusionid']);
							$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $field['name']);
							$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $field['department_name']);
							$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $field['office_id']);
							$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $field['assigned_to_fusionid']);
							$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $field['assigned_to']);
							$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $field['course_name']);
							$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $field['is_view'] == 1?'Started Reading':'Not Opened Yet');
							$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $field['is_complete'] == 1?'Course Marked Completed':'Course Not Marked Completed');
							$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $field['is_complete'] == 1?$field['exam_start_time']:'');
							$col++;
							$row++;
						}
			 
		   }elseif($catgories == 'E'){
			   
			   $objPHPExcel->getActiveSheet()->getStyle('A1:M1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('008000');
			   $objPHPExcel->getActiveSheet()->getStyle("A1:M1")->applyFromArray(
									array(
										'borders' => array(
											'allborders' => array(
												'style' => PHPExcel_Style_Border::BORDER_THIN,
												'color' => array('rgb' => '000000')
											)
										)
									)
								);
			   $objPHPExcel->getActiveSheet()->getStyle("A1:M1")->getFont()->setBold(true)
                                ->setName('Verdana')
                                ->setSize(10)
                                ->getColor()->setRGB('ffffff');
			   
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1,'Fusion ID');
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 1,'Agent Name');
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 1,'Department Name');
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, 1,'Location');
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, 1,'Assigned To FID');
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, 1,'Assigned TO');
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, 1,'Course Name');
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, 1,'Set Name');
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, 1,'Date of Completion');
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, 1,'Pass Marks');
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, 1,'Attempted Questions');
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, 1,'Scored');
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, 1,'Result');
						$colstr='A';
						foreach ($data_excel as $field)
						{
								$objPHPExcel->getActiveSheet()->getColumnDimension($colstr++)->setAutoSize(true);
								
								$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $field['fusionid']);
								$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $field['username']);
								$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $field['department_name']);
								$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $field['office_id']);
								$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $field['assigned_to_fusionid']);
								$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $field['assigned_to']);
								$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $field['description']);
								$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $field['set_name']);
								$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $field['exam_start_time']);
								$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $field['pass_marks']);
								$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $row, $field['attempted_question']);
								$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $row, $field['scored']);
								$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $row, $field['passed'] == 1?'Passed':'Failed');
							$col++;
							$row++;
						}
						
		   }
		   
					ob_clean() ;
					
					$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		 
			    	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
					header("Cache-Control: no-store, no-cache, must-revalidate");
					header("Cache-Control: post-check=0, pre-check=0", false);
					header("Pragma: no-cache");
					header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
					if($catgories == 'A'){
						header('Content-Disposition: attachment;filename="Assigned Users.xlsx"');
					}elseif($catgories == 'E'){
						header('Content-Disposition: attachment;filename="Examination.xlsx"');
					}
					
					ob_end_clean();
					 
					
					$objWriter->save("php://output");
					unset($objPHPExcel);
					exit(); 
        }
   }
   
   //**************************************************************************************************
   // 								GET ID USING FUSION ID
   //**************************************************************************************************
   
   public function get_user_id($fusion_id){
	  
		$SQLtxt = "SELECT id FROM signin where fusion_id= '". trim($fusion_id) ."'";
		$query = $this->db->query($SQLtxt);
		
		$fileds =   $query->row();
			
		return $fileds->id;
		
	   
   }
   
   //**************************************************************************************************
   // 								UPLOAD EXCEL CO-ORDINATOR EXCEL
   //**************************************************************************************************
   
   public function upload_cordinator_excel(){
	    if(check_logged_in()){
			//'log'=>get_logs());
			
			$this->load->library('excel');
		
			$config['upload_path']          = './course_uploads/converted/';
			$config['allowed_types']        = 'xls|xlsx';
			$config['max_size']             = 400000;
			
			$this->load->library('upload', $config);
		
			if($this->input->post('upload_excel') == 'upload_excel'){	
				
				$course_categories = $this->input->post('course_categories');
				
				if($course_categories != ''){
					if ( ! $this->upload->do_upload('upload_cordinator')){
							$error = array('error' => $this->upload->display_errors());
							echo "Error File Uploads";
							redirect('course');
					}else{
							$data = array('upload_data' => $this->upload->data());
					}
				}
			}
		   
			if($course_categories != ''){
				
				$file_path = $config['upload_path'].'/'.$data['upload_data']['file_name'];
				
				$inputFileType = PHPExcel_IOFactory::identify($file_path);
				$objReader = PHPExcel_IOFactory::createReader($inputFileType);
				$objReader->setReadDataOnly(true);
				
				$objPHPExcel = $objReader->load($file_path);
				
				$objPHPExcel->setActiveSheetIndex(0);
				$objWorksheet = $objPHPExcel->getActiveSheet();
				
				$highestRow = $objWorksheet->getHighestRow();
				$highestColumn = $objWorksheet->getHighestColumn();
				$worksheetTitle = $objWorksheet->getTitle();
				
				for($row = 2; $row <= $highestRow; $row++)
				{
					$user_id = $this->get_user_id($objWorksheet->getCell('A'.$row)->getValue());
					
					if($user_id!=""){
						$SQLtxt ="REPLACE INTO course_assign_cordinator(category_id,user_id,assigned_by)VALUES(". $course_categories .",". $user_id .",". get_user_id() .")";
						$this->db->query($SQLtxt);
					}
				}
				
			}
				redirect('course');
	   }
	   
   }
   
   //**************************************************************************************************
   // 								UPLOAD EXCEL ASSIGN USER EXCEL
   //**************************************************************************************************
   
      public function upload_assign_user_excel(){
	    if(check_logged_in()){
			//'log'=>get_logs());
			
			$this->load->library('excel');
		
			$config['upload_path']          = './course_uploads/converted/';
			$config['allowed_types']        = 'xls|xlsx';
			$config['max_size']             = 400000;
			
			$this->load->library('upload', $config);
		
			if($this->input->post('upload_excel') == 'upload_excel'){	
				
				echo $categ_id  = $this->input->post('category_id');
				echo $course_id = $this->input->post('course_id');
				
				if($course_id != ''){
					if ( ! $this->upload->do_upload('upload_assign_users')){
							$error = array('error' => $this->upload->display_errors());
							echo "Error File Uploads";
							redirect('course');
					}else{
							$data = array('upload_data' => $this->upload->data());
					}
				}
			}
		   
			if($course_id != ''){
				
				$file_path = $config['upload_path'].'/'.$data['upload_data']['file_name'];
				
				$inputFileType = PHPExcel_IOFactory::identify($file_path);
				$objReader = PHPExcel_IOFactory::createReader($inputFileType);
				$objReader->setReadDataOnly(true);
				
				$objPHPExcel = $objReader->load($file_path);
				
				$objPHPExcel->setActiveSheetIndex(0);
				$objWorksheet = $objPHPExcel->getActiveSheet();
				
				$highestRow = $objWorksheet->getHighestRow();
				$highestColumn = $objWorksheet->getHighestColumn();
				$worksheetTitle = $objWorksheet->getTitle();
				
				for($row = 2; $row <= $highestRow; $row++)
				{
					$user_id = $this->get_user_id($objWorksheet->getCell('A'.$row)->getValue());
					
					if($user_id!=""){
						$SQLtxt ="REPLACE INTO course_assign_agents(category_id,course_id,agent_id,is_view,is_complete,is_global,is_active,created_by,log)VALUES(". $categ_id .",". $course_id .",". $user_id .",0,0,0,1,". get_user_id() .",'". get_logs() ."')";
						$this->db->query($SQLtxt); 
					}
					 
				}
				
			}
				redirect('course/assign_users/'.$categ_id);
	   }
	   
   }
   
   
   public function report_analytics($category,$course){
	   
	   //$SQLtxt = "SELECT count(ans_id)as no_options,(SELECT title from lt_questions WHERE lt_questions.id = course_lt_user_exam_answer.ques_id )as questions, (SELECT text from lt_questions_ans_options WHERE lt_questions_ans_options.id = course_lt_user_exam_answer.ans_id)as questions_ans FROM `course_lt_user_exam_answer` where ques_id=811 GROUP BY ans_id";
	  // $SQLtxt = "SELECT    course_lt_exam_schedule.user_id,count(ans_id)as no_options,(SELECT title from lt_questions WHERE lt_questions.id = course_lt_user_exam_answer.ques_id )as questions, (SELECT text from lt_questions_ans_options WHERE lt_questions_ans_options.id = course_lt_user_exam_answer.ans_id)as questions_ans FROM `course_lt_user_exam_answer` 
		/* 		INNER JOIN course_lt_exam_schedule ON course_lt_exam_schedule.id = course_lt_user_exam_answer.exam_schedule_id INNER JOIN
				course_examination ON course_lt_exam_schedule.module_id = course_examination.exam_id
				GROUP BY ans_id";
 */
 
		/* $SQLtxt = "SELECT  *,  (SELECT id from lt_questions WHERE lt_questions.id = course_lt_user_exam_answer.ques_id )as questions,course_lt_exam_schedule.user_id,count(ans_id)as no_options,(SELECT title from lt_questions WHERE lt_questions.id = course_lt_user_exam_answer.ques_id )as questions, (SELECT text from lt_questions_ans_options WHERE lt_questions_ans_options.id = course_lt_user_exam_answer.ans_id)as questions_ans FROM `course_lt_user_exam_answer` 
					INNER JOIN course_lt_exam_schedule ON course_lt_exam_schedule.id = course_lt_user_exam_answer.exam_schedule_id INNER JOIN 
					course_examination ON course_examination.module_id = course_lt_exam_schedule.module_id WHERE course_examination.categories_id = 22 AND  course_examination.course_id = 33
					GROUP BY ans_id"; 
					
				$SQLtxt ="SELECT lt_questions.id as ques_id,lt_questions_ans_options.id,lt_questions_ans_options.text, (SELECT count(*) from course_lt_user_exam_answer
						  WHERE course_lt_user_exam_answer.ans_id = lt_questions_ans_options.id)as total_ans, (SELECT count(*) from course_lt_user_exam_answer 
						  WHERE course_lt_user_exam_answer.ans_id = lt_questions_ans_options.id AND lt_questions_ans_options.correct_answer=1)as total_correct_ans 
						  FROM lt_questions INNER JOIN lt_questions_ans_options ON lt_questions_ans_options.ques_id = lt_questions.id INNER JOIN course_lt_user_exam_answer 
						  on course_lt_user_exam_answer.ques_id = lt_questions.id INNER JOIN course_lt_exam_schedule ON course_lt_exam_schedule.id = 
						  course_lt_user_exam_answer.exam_schedule_id INNER JOIN course_examination ON course_examination.module_id = 
						  course_lt_exam_schedule.module_id WHERE course_examination.categories_id = 22 AND course_examination.course_id = 33";	
					*/
					
			$data["aside_template"] = "course/aside.php";
			$data["content_template"] = "course/course_analytics_pdf.php";
			$data['prof_pic_url']=  $this->Profile_model->get_profile_pic(get_user_fusion_id());
			$data['categ_id'] = $category;
			$data['course_id'] = $course;
			
			$SQLtxt = "SELECT * FROM course_detail WHERE categories_id=". $category ." AND course_id=". $course ."";
			$data['course_name'] = $this->Common_model->get_query_row_array($SQLtxt); 
			
			$SQLtxt ="select distinct(lt_questions.id) as ques_id,lt_questions.title as title from lt_questions INNER JOIN lt_questions_ans_options ON lt_questions_ans_options.ques_id = lt_questions.id INNER JOIN course_lt_user_exam_answer 
					  on course_lt_user_exam_answer.ques_id = lt_questions.id INNER JOIN course_lt_exam_schedule ON course_lt_exam_schedule.id = 
					  course_lt_user_exam_answer.exam_schedule_id INNER JOIN course_examination ON course_examination.module_id = 
					  course_lt_exam_schedule.module_id WHERE course_examination.categories_id = ". $category ." AND course_examination.course_id = ". $course ."";
					  
			$data['course_question'] = $this->Common_model->get_query_result_array($SQLtxt);  		  
			
			
			foreach($data['course_question'] as $questions){
				$data['c_question'][$questions['ques_id']] = $questions['title'];
				
				 $SQLtxt ="SELECT trim(lt_questions_ans_options.text) as text,lt_questions.id as ques_ids ,(SELECT count(*) from course_lt_user_exam_answer
						  WHERE course_lt_user_exam_answer.ans_id = lt_questions_ans_options.id)as total_ans, (SELECT count(*) from course_lt_user_exam_answer 
						  WHERE course_lt_user_exam_answer.ans_id = lt_questions_ans_options.id AND lt_questions_ans_options.correct_answer=1)as total_correct_ans,
						  lt_questions_ans_options.correct_answer
						  FROM lt_questions INNER JOIN lt_questions_ans_options ON lt_questions_ans_options.ques_id = lt_questions.id 
						  WHERE lt_questions.id = ".  $questions['ques_id'] ."";
	 
				$data['course_analytics'][$questions['ques_id']]  =  $questions['ques_id'];
				$data['course_analytics'][$questions['ques_id']] = $this->Common_model->get_query_result_array($SQLtxt);  
				
			}
			
			$SQLtxt ="SELECT SUM((scored) >=45 AND (scored) <=100) as score_1,scored as scored FROM course_lt_exam_schedule INNER JOIN course_examination ON course_examination.exam_id = course_lt_exam_schedule.exam_id AND course_examination.module_id = course_lt_exam_schedule.module_id WHERE course_examination.categories_id = ". $category ." AND course_examination.course_id =". $course ." GROUP BY scored ORDER BY scored";
			$analytics_rating_3 = ($this->Common_model->get_query_result_array($SQLtxt));
			
			$data['analytics_report'] = $analytics_rating_3;
			
		    //$html = $this->load->view('course/course_analytics_pdf.php', $data, TRUE); 
			//$this->generate_pdf_files($html,'samplet-test',1,'N'); 
			
	   $this->load->view('dashboard_single_col',$data);
	   
   }
   
   
   
   public function generate_pdf_files($html,$filename,$flags,$isSave='Y'){
		
		ob_start();  // start output buffering
		$this->load->library('m_pdf');
		$this->m_pdf->pdf = new mPDF('c');
		
		
		if($flags == 1){
				
				$header_html = "<div class><img src='". APPPATH ."/../assets/images/logoxt.jpg' height='70px'></div>";
				
				$header_footer = "<p style='text-align:center; font-weight:lighter; '><span style='font-size:14px'>XPLORE-TECH SERVICES PRIVATE LIMITED</span><br>
				<span style='text-align:center; font-size:11px'><i>(A Fusion BPO Services Company)</i></span><br>
				<span style='text-align:center; font-size:11px'>Plot Y9, Block-EP, Sector-V, Salt Lake City, Kolkata-700091</span><br>
				<span style='text-align:center; font-size:11px'>www. xplore-tech.com</span><br>
				<span style='text-align:center; font-size:11px'>www.fusionbposervices.com</span></p>";
			 }
			
			$this->m_pdf->pdf->SetHTMLHeader($header_html);
			$this->m_pdf->pdf->SetHTMLFooter($header_footer);	
	
		
		$this->m_pdf->shrink_tables_to_fit;
		   //generate the PDF from the given html
		$this->m_pdf->pdf->WriteHTML($html);
		$attachment_path =FCPATH."temp_files/course_analytics/".$filename.".pdf";
		
			if($isSave=="Y") {
				
				$this->m_pdf->pdf->Output($attachment_path, "F");
				ob_clean();
				return $attachment_path;
			}
			else{
				ob_clean();
				$this->m_pdf->pdf->Output($filename.".pdf", "D"); 
				
			}
						
		// Open this send mail for Testing Purpous.... else use the email model for email sending.. as email logs is created there
		//$this->send_mail_withattachment($individual_user,$attachment_path,$subject,$smtp_from_name,$is_mail_info);
		
		}
   
}