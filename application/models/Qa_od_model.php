<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Qa_od_model extends CI_Model {
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();	
    }
	
	/////////// feedback_entry ///////////////
	
	
	public function data_insert_feedback_entry($field_array)
	{
		$this->db->insert('qa_od_feedback', $field_array);
	}
	
	public function get_agent_id($cid)
	{	
		$qsql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,$cid) and status=1  order by name";
		
		$query = $this->db->query($qsql);
		return $query->result();	
	}
	
	public function get_tl_id()
	{
		$qsql="SELECT id, concat(fname, ' ', lname) as name, fusion_id FROM `signin` where role_id = 2";
		
		$query = $this->db->query($qsql);
		return $query->result();
	}
	
	public function view_feedback_entry_data($_id)
	{	
		$qsql = "SELECT * from 
				(Select f.*, (select concat(fname, ' ', lname) FROM signin s where s.id=f.agent_id) as agent_name, (select concat(fname, ' ', lname) FROM signin s where s.id=f.entry_by) as qa_name, mr.mgnt_review_date, mr.note as mgnt_note FROM qa_od_feedback f left join qa_od_mgnt_review mr ON f.id = mr.fd_id where f.id='$_id') xx 
				Left Join (Select * from qa_od_agent_review) yy
				ON (xx.id=yy.fd_id) ";
				
		$query = $this->db->query($qsql);
		return $query->result();
	}
	
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	
	public function get_management_review_data($field_array) 
    {	
		$from_date= $field_array['from_date'];
		$to_date= $field_array['to_date'];
		$agent_id= $field_array['agent_id'];
		$current_user= $field_array['current_user'];
		$cond="";
		
		if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date' ) ";
		if($agent_id!="") $cond .=" and agent_id='$agent_id'";	
		
		if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
			$cond .=" And (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
		}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
			$cond .=" And assigned_to='$current_user'";
		}else{
			$cond .="";
		}
		
		$qsql = "SELECT * from (Select f.*, ( select concat(fname, ' ', lname) FROM signin s where s.id=f.agent_id) as agent_name, (select concat(fname, ' ', lname) FROM signin s where s.id=f.entry_by) as qa_name,ar.agent_fd_acpt as agent_fd_acpt,ar.review_date as agent_review_date, ar.note as agent_note, mr.mgnt_review_date, mr.note  as mgnt_note FROM qa_od_feedback f left join qa_od_agent_review ar ON f.id = ar.fd_id left join qa_od_mgnt_review mr ON f.id = mr.fd_id) xx Left Join (Select id as sid, fusion_id, office_id, get_process_names(id) as campaign, DATEDIFF(CURDATE(), doj) as tenure, assigned_to from signin) yy on (xx.agent_id=yy.sid)  $cond ";
		
		$query = $this->db->query($qsql);
		return $query->result();  
	  
	}

	public function get_voice_review_data($field_array) 
    {	
		$from_date= $field_array['from_date'];
		$to_date= $field_array['to_date'];
		$agent_id= $field_array['agent_id'];
		$current_user= $field_array['current_user'];
		$cond="";
		
		if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date' ) ";
		if($agent_id!="") $cond .=" and agent_id='$agent_id'";	
		
		if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
			$cond .=" And (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
		}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
			$cond .=" And assigned_to='$current_user'";
		}else{
			$cond .="";
		}
		
		$od_sql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_od_voice_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $cond order by audit_date";
		$query = $this->db->query($od_sql);
		return $query->result();    
	}

	public function get_business_direct_data($field_array) 
    {	
		$from_date= $field_array['from_date'];
		$to_date= $field_array['to_date'];
		$agent_id= $field_array['agent_id'];
		$current_user= $field_array['current_user'];
		$cond="";
		
		if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date' ) ";
		if($agent_id!="") $cond .=" and agent_id='$agent_id'";	
		
		if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
			$cond .=" And (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
		}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
			$cond .=" And assigned_to='$current_user'";
		}else{
			$cond .="";
		}
		
		$od_sql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_od_business_direct_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $cond order by audit_date";
		$query = $this->db->query($od_sql);
		return $query->result();    
	}

	public function get_ecommerce_review_data($field_array) 
    {	
		$from_date= $field_array['from_date'];
		$to_date= $field_array['to_date'];
		$agent_id= $field_array['agent_id'];
		$current_user= $field_array['current_user'];
		$cond="";
		
		if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date' ) ";
		if($agent_id!="") $cond .=" and agent_id='$agent_id'";	
		
		if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
			$cond .=" And (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
		}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
			$cond .=" And assigned_to='$current_user'";
		}else{
			$cond .="";
		}
		
		$od_sql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_od_ecommerce_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $cond order by audit_date";
		$query = $this->db->query($od_sql);
		return $query->result();    
	}

public function get_chat_review_data($field_array) 
    {	
		$from_date= $field_array['from_date'];
		$to_date= $field_array['to_date'];
		$agent_id= $field_array['agent_id'];
		$current_user= $field_array['current_user'];
		$cond="";
		
		if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date' ) ";
		if($agent_id!="") $cond .=" and agent_id='$agent_id'";	
		
		if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
			$cond .=" And (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
		}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
			$cond .=" And assigned_to='$current_user'";
		}else{
			$cond .="";
		}
		
		$od_sql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_od_chat_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $cond order by audit_date";
		$query = $this->db->query($od_sql);
		return $query->result();    
	}
///////////////nps ACPT/////////////////////////////
	public function get_nps_review_data($field_array) 
    {	
		$from_date= $field_array['from_date'];
		$to_date= $field_array['to_date'];
		$agent_id= $field_array['agent_id'];
		$current_user= $field_array['current_user'];
		$cond="";
		
		if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date' ) ";
		if($agent_id!="") $cond .=" and agent_id='$agent_id'";	
		
		if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
			$cond .=" And (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
		}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
			$cond .=" And assigned_to='$current_user'";
		}else{
			$cond .="";
		}
		
		$od_sql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from  qa_od_npsACPT_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $cond order by audit_date";
		$query = $this->db->query($od_sql);
		return $query->result();    
	}

	
	public function view_management_review_data($_id)
	{
		$qsql="SELECT * FROM qa_od_mgnt_review where fd_id='$_id'";
		$query = $this->db->query($qsql);
		return $query->row_array();
	}
	
	
	public function get_agent_fullname()
	{
		$qsql="SELECT id, concat(fname, ' ', lname) as name FROM `signin` where role_id in (select id from role where folder ='agent')";
		$query = $this->db->query($qsql);
		return $query->result();
	}
	
	public function get_tl_name()
	{
		//$qsql="SELECT id, concat(fname, ' ', lname) as name, fusion_id FROM `signin` where role_id = 2";
		$qsql="SELECT id, concat(fname, ' ', lname) as name, fusion_id FROM `signin` where role_id in (select id from role where folder = 'manager')";
		$query = $this->db->query($qsql);
		return $query->result();
	}
	
	
	public function get_agent_not_review_data($current_user) 
    {
		$qsql = " SELECT f.*, ( select concat(fname, ' ', lname) FROM signin s where s.id=f.agent_id) as agent_name, (select concat(fname, ' ', lname) FROM signin s where s.id=f.entry_by) as qa_name, ar.review_date as agent_review_date, ar.note as agent_note, mr.mgnt_review_date as mgnt_review_date, mr.note as mgnt_note FROM qa_od_feedback f left join qa_od_agent_review ar ON f.id = ar.fd_id left join qa_od_mgnt_review mr ON f.id = mr.fd_id where f.id not in (select fd_id from qa_od_agent_review ) and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit')";
		$query = $this->db->query($qsql);
		return $query->result();  
	  
	}

	public function get_agent_not_voice_data($current_user) 
    {
		$od_qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_od_voice_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
		$query = $this->db->query($od_qSql);
		return $query->result_array();  
	  
	}
	
	
	public function view_agent_review_data($_id)
	{
		$qsql="SELECT * FROM qa_od_agent_review where fd_id='$_id'";
		$query = $this->db->query($qsql);
		return $query->row_array();
	}
	
	
	public function get_agent_review_data($field_array) 
    {
		$from_date= $field_array['from_date'];
		$to_date= $field_array['to_date'];
		$current_user= $field_array['current_user'];
		$cond="";
		
		if($from_date !="" && $to_date!=="" )  $cond= " Where (chat_date >= '$from_date' and chat_date <= '$to_date' ) And audit_type in ('CQ Audit', 'BQ Audit')";
		
		if( $current_user !=""){
			if($cond=="")  $cond= " Where agent_id='$current_user' ";
			else  $cond .= " and agent_id='$current_user' ";
		}
				
		$qsql = " SELECT f.*, (select concat(fname, ' ', lname) FROM signin s where s.id=f.agent_id) as agent_name, (select concat(fname, ' ', lname) FROM signin s where s.id=f.entry_by) as qa_name,ar.agent_fd_acpt as agent_fd_acpt ,ar.review_date as agent_review_date, ar.note as agent_note, mr.mgnt_review_date as mgnt_review_date, mr.note  as mgnt_note FROM qa_od_feedback f left join qa_od_agent_review ar ON f.id = ar.fd_id left join qa_od_mgnt_review mr ON f.id = mr.fd_id $cond ";
		$query = $this->db->query($qsql);
		return $query->result(); 
	}

	public function get_agent_voice_data($field_array) 
    {
		$from_date= $field_array['from_date'];
		$to_date= $field_array['to_date'];
		$current_user= $field_array['current_user'];
		$cond="";
		
		if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date' )";
		
		if( $current_user !=""){
			if($cond=="")  $cond= " Where agent_id='$current_user' ";
			else  $cond .= " and agent_id='$current_user' ";
		}
				
		$voice_qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_od_voice_feedback $cond And audit_type in ('CQ Audit', 'BQ Audit','Operation Audit','Trainer Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";

		$query = $this->db->query($voice_qSql);
		return $query->result_array(); 
	}

	public function get_agent_business_direct_data($field_array) 
    {
		$from_date= $field_array['from_date'];
		$to_date= $field_array['to_date'];
		$current_user= $field_array['current_user'];
		$cond="";
		
		if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date' )";
		
		if( $current_user !=""){
			if($cond=="")  $cond= " Where agent_id='$current_user' ";
			else  $cond .= " and agent_id='$current_user' ";
		}
				
		$business_qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_od_business_direct_feedback $cond And audit_type not in ('Calibration', 'Pre-Certificate Mock Call', 'Certification Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";

		$query = $this->db->query($business_qSql);
		return $query->result_array(); 
	}

	public function get_agent_od_nps_coaching_data($field_array) 
    {
		$from_date= $field_array['from_date'];
		$to_date= $field_array['to_date'];
		$current_user= $field_array['current_user'];
		$cond="";
		
		if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date' )";
		
		if( $current_user !=""){
			if($cond=="")  $cond= " Where agent_id='$current_user' ";
			else  $cond .= " and agent_id='$current_user' ";
		}
				
		$voice_qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_agent_coaching_office_depot_feedback $cond And audit_type in ('CQ Audit', 'BQ Audit','Operation Audit','Trainer Audit')) xx Left Join
				(Select id as sid, concat(fname, ' ', lname) as agent_name, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";

		$query = $this->db->query($voice_qSql);
		return $query->result_array(); 
	}

	public function get_agent_nps_data($field_array) 
    {
		$from_date= $field_array['from_date'];
		$to_date= $field_array['to_date'];
		$current_user= $field_array['current_user'];
		$cond="";
		
		if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date' )";
		
		if( $current_user !=""){
			if($cond=="")  $cond= " Where agent_id='$current_user' ";
			else  $cond .= " and agent_id='$current_user' ";
		}
				
		$voice_qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_od_npsACPT_feedback $cond And audit_type in ('CQ Audit', 'BQ Audit','Operation Audit','Trainer Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";

		$query = $this->db->query($voice_qSql);
		return $query->result_array(); 
	}

	public function get_agent_ecommerce_data($field_array) 
    {
		$from_date= $field_array['from_date'];
		$to_date= $field_array['to_date'];
		$current_user= $field_array['current_user'];
		$cond="";
		
		if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date' )";
		
		if( $current_user !=""){
			if($cond=="")  $cond= " Where agent_id='$current_user' ";
			else  $cond .= " and agent_id='$current_user' ";
		}
				
		$ecommerce_qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_od_ecommerce_feedback $cond And audit_type in ('CQ Audit', 'BQ Audit','Operation Audit','Trainer Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
		
		$query = $this->db->query($ecommerce_qSql);
		return $query->result_array(); 
	}

	public function get_agent_chat_data($field_array) 
    {
		$from_date= $field_array['from_date'];
		$to_date= $field_array['to_date'];
		$current_user= $field_array['current_user'];
		$cond="";
		
		if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date' ) And audit_type in ('CQ Audit', 'BQ Audit','Calibration')";
		
		if( $current_user !=""){
			if($cond=="")  $cond= " Where agent_id='$current_user' ";
			else  $cond .= " and agent_id='$current_user' ";
		}
				
		$voice_qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_od_chat_feedback $cond And audit_type in ('CQ Audit', 'BQ Audit','Operation Audit','Trainer Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";

		$query = $this->db->query($voice_qSql);
		return $query->result_array(); 
	}

	
	
}
?>	