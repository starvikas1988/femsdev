<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Qa_vrs_model extends CI_Model {
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();	
    }

/////////////////////////////
		private $RepDB=null;
	
		public function set_report_database($group="default"){	
			$this->RepDB = $this->load->database($group,TRUE);
		}
//////////////////////////	

	
	public function get_agent_id($cid,$cid1,$pid,$pid1)
	{	
		$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and (is_assign_client (id,$cid) or is_assign_client (id,$cid1)) and (is_assign_process (id,$pid) or is_assign_process (id,$pid1)) and status=1  order by name";
		$query = $this->db->query($qSql);
		return $query->result_array();	
	}
	
	
/*--------------------------------VRS RP----------------------------------------*/
	public function get_vrs_rp_data($field_array) 
    {		
		$from_date= $field_array['from_date'];
		$to_date= $field_array['to_date'];		
		$current_user= $field_array['current_user'];	
		$cond="";
		
		if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date' ) ";
		
		if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
			$ops_cond=" Where (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
		}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
			$ops_cond=" Where assigned_to='$current_user'";
		}else{
			$ops_cond="";
		}
		
		$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name from qa_vrs_rp_feedback $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, doj, assigned_to from signin) yy on (xx.agent_id=yy.sid) Left join (Select fd_id, note as agent_note, date(entry_date) as agent_rvw_date from qa_vrs_rp_agent_rvw) zz on (xx.id=zz.fd_id) Left Join (Select fd_id as mgnt_fd_id, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as mgnt_name, note as mgnt_note, date(entry_date) as mgnt_rvw_date from qa_vrs_rp_mgnt_rvw) ww on (xx.id=ww.mgnt_fd_id) $ops_cond order by audit_date";
		
		
		$query = $this->db->query($qSql);
		return $query->result_array();
	}
	
	public function view_vrs_rp_feedback($_id)
	{
		$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name from qa_vrs_rp_feedback where id='$_id') xx Left Join (Select id as sid, fname, lname, fusion_id, doj from signin) yy on (xx.agent_id=yy.sid)";
		$query = $this->db->query($qSql);
		return $query->result_array();
	}
	
	public function view_mgnt_vrs_rp_rvw($_id)
	{
		$qSql="Select * FROM qa_vrs_rp_mgnt_rvw where fd_id='$_id'";
		$query = $this->db->query($qSql);
		return $query->row_array();
	}
	
	public function view_agent_vrs_rp_rvw($_id)
	{
		$qsql="Select * FROM qa_vrs_rp_agent_rvw where fd_id='$_id'";
		$query = $this->db->query($qsql);
		return $query->row_array();
	}
	
	
	public function get_agent_rp_review_data($field_array) 
    {
		$from_date= $field_array['from_date'];
		$to_date= $field_array['to_date'];		
		$current_user= $field_array['current_user'];
		$cond="";
		
		if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date' ) ";
		
		$qSql = "SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name from qa_vrs_rp_feedback $cond and agent_id='$current_user' And audit_type!='Calibration') xx Left Join (Select id as sid, fname, lname, fusion_id, doj from signin) yy on (xx.agent_id=yy.sid) Left join (Select fd_id, note as agent_note, date(entry_date) as agent_rvw_date from qa_vrs_rp_agent_rvw) zz on (xx.id=zz.fd_id) Left Join (Select fd_id as mgnt_fd_id, note as mgnt_note, date(entry_date) as mgnt_rvw_date, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as mgnt_name from qa_vrs_rp_mgnt_rvw) ww on (xx.id=ww.mgnt_fd_id)";
		$query = $this->db->query($qSql);
		return $query->result_array(); 
	}
	
	
	public function get_agent_not_rp_review_data($current_user)
    {
		$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name from qa_vrs_rp_feedback where agent_id='$current_user' And audit_type!='Calibration') xx Left Join (Select id as sid, fname, lname, fusion_id, doj from signin) yy on (xx.agent_id=yy.sid) Left join (Select fd_id, note as agent_note, date(entry_date) as agent_rvw_date from qa_vrs_rp_agent_rvw) zz on (xx.id=zz.fd_id) Left Join (Select fd_id as mgnt_fd_id, note as mgnt_note, date(entry_date) as mgnt_rvw_date, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as mgnt_name from qa_vrs_rp_mgnt_rvw) ww on (xx.id=ww.mgnt_fd_id) where xx.id not in (select fd_id from qa_vrs_rp_agent_rvw)";
		$query = $this->db->query($qSql);
		return $query->result_array();
	}
    //--------------------------New Left Message----------//
	public function get_new_lm_vrs($field_array) 
    {		
		$from_date= $field_array['from_date'];
		$to_date= $field_array['to_date'];	
		$current_user= $field_array['current_user'];	
		$cond="";
		
		if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date' ) ";
		
		if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
			$ops_cond=" Where (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
		}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
			$ops_cond=" Where assigned_to='$current_user'";
		}else{
			$ops_cond="";
		}
		$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_new_lm_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as process, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
		$query = $this->db->query($qSql);
		return $query->result_array();
	}

	/*--------------------------------VRS LM---------------------------------------*/
	public function get_vrs_lm_data($field_array) 
    {		
		$from_date= $field_array['from_date'];
		$to_date= $field_array['to_date'];	
		$current_user= $field_array['current_user'];	
		$cond="";
		
		if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date' ) ";
		
		if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
			$ops_cond=" Where (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
		}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
			$ops_cond=" Where assigned_to='$current_user'";
		}else{
			$ops_cond="";
		}
		
		$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name from qa_vrs_lm_feedback $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, doj, assigned_to from signin) yy on (xx.agent_id=yy.sid) Left join (Select fd_id, note as agent_note, date(entry_date) as agent_rvw_date from qa_vrs_lm_agent_rvw) zz on (xx.id=zz.fd_id) Left Join (Select fd_id as mgnt_fd_id, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as mgnt_name, note as mgnt_note, date(entry_date) as mgnt_rvw_date from qa_vrs_lm_mgnt_rvw) ww on (xx.id=ww.mgnt_fd_id) $ops_cond order by audit_date";
		$query = $this->db->query($qSql);
		return $query->result_array();
	}

	public function view_vrs_lm_feedback($_id)
	{
		$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name from qa_vrs_lm_feedback where id='$_id') xx Left Join (Select id as sid, fname, lname, fusion_id, doj from signin) yy on (xx.agent_id=yy.sid)";
		$query = $this->db->query($qSql);
		return $query->result_array();
	}
	
	public function view_mgnt_vrs_lm_rvw($_id)
	{
		$qSql="Select * FROM qa_vrs_lm_mgnt_rvw where fd_id='$_id'";
		$query = $this->db->query($qSql);
		return $query->row_array();
	}
	
	public function view_agent_vrs_lm_rvw($_id)
	{
		$qsql="Select * FROM qa_vrs_lm_agent_rvw where fd_id='$_id'";
		$query = $this->db->query($qsql);
		return $query->row_array();
	}
	
	public function get_agent_lm_review_data($field_array) 
    {
		$from_date= $field_array['from_date'];
		$to_date= $field_array['to_date'];		
		$current_user= $field_array['current_user'];
		$cond="";
		
		if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date' ) ";
		
		$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_new_lm_feedback $cond And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Inner Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin $current_user) yy on (xx.agent_id=yy.sid)";
		
		$query = $this->db->query($qSql);
		return $query->result_array(); 
	}
		
	public function get_agent_not_lm_review_data($current_user)
    {
		$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name from qa_vrs_lm_feedback where agent_id='$current_user' And audit_type!='Calibration') xx Left Join (Select id as sid, fname, lname, fusion_id, doj from signin) yy on (xx.agent_id=yy.sid) Left join (Select fd_id, note as agent_note, date(entry_date) as agent_rvw_date from qa_vrs_lm_agent_rvw) zz on (xx.id=zz.fd_id) Left Join (Select fd_id as mgnt_fd_id, note as mgnt_note, date(entry_date) as mgnt_rvw_date, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as mgnt_name from qa_vrs_lm_mgnt_rvw) ww on (xx.id=ww.mgnt_fd_id) where xx.id not in (select fd_id from qa_vrs_lm_agent_rvw)";
		$query = $this->db->query($qSql);
		return $query->result_array();
	}
	
	/*--------------------------------VRS Cavalry---------------------------------------*/
	public function get_vrs_cav_data($field_array) 
    {		
		$from_date= $field_array['from_date'];
		$to_date= $field_array['to_date'];	
		$current_user= $field_array['current_user'];	
		$cond="";
		
		if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date' ) ";
		
		if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
			$ops_cond=" Where (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
		}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
			$ops_cond=" Where assigned_to='$current_user'";
		}else{
			$ops_cond="";
		}
		
		$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name from qa_vrs_cavalry_feedback $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, doj, assigned_to from signin) yy on (xx.agent_id=yy.sid) Left join (Select fd_id, note as agent_note, date(entry_date) as agent_rvw_date from qa_vrs_cavalry_agent_rvw) zz on (xx.id=zz.fd_id) Left Join (Select fd_id as mgnt_fd_id, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as mgnt_name, note as mgnt_note, date(entry_date) as mgnt_rvw_date from qa_vrs_cavalry_mgnt_rvw) ww on (xx.id=ww.mgnt_fd_id) $ops_cond order by audit_date";
		$query = $this->db->query($qSql);
		return $query->result_array();
	}
	
	public function view_vrs_cav_feedback($_id)
	{
		$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,get_process_names(agent_id) AS process_name from qa_vrs_cavalry_feedback where id='$_id') xx Left Join (Select id as sid, fname, lname, fusion_id, doj from signin) yy on (xx.agent_id=yy.sid)";
		$query = $this->db->query($qSql);
		return $query->result_array();
	}
	
	public function view_mgnt_vrs_cap_rvw($_id)
	{
		$qSql="Select * FROM qa_vrs_cavalry_mgnt_rvw where fd_id='$_id'";
		$query = $this->db->query($qSql);
		return $query->row_array();
	}
	
	public function view_agent_vrs_cap_rvw($_id)
	{
		$qsql="Select * FROM qa_vrs_cavalry_agent_rvw where fd_id='$_id'";
		$query = $this->db->query($qsql);
		return $query->row_array();
	}
	
	public function get_agent_cav_review_data($field_array) 
    {
		$from_date= $field_array['from_date'];
		$to_date= $field_array['to_date'];		
		$current_user= $field_array['current_user'];
		$cond="";
		
		if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date' ) ";
		
		$qSql = "SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name from qa_vrs_cavalry_feedback $cond and agent_id='$current_user' And audit_type!='Calibration') xx Left Join (Select id as sid, fname, lname, fusion_id, doj from signin) yy on (xx.agent_id=yy.sid) Left join (Select fd_id, note as agent_note, date(entry_date) as agent_rvw_date from qa_vrs_cavalry_agent_rvw) zz on (xx.id=zz.fd_id) Left Join (Select fd_id as mgnt_fd_id, note as mgnt_note, date(entry_date) as mgnt_rvw_date, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as mgnt_name from qa_vrs_cavalry_mgnt_rvw) ww on (xx.id=ww.mgnt_fd_id)";
		$query = $this->db->query($qSql);
		return $query->result_array(); 
	}
		
	public function get_agent_not_cav_review_data($current_user)
    {
		$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name from qa_vrs_cavalry_feedback where agent_id='$current_user' And audit_type!='Calibration') xx Left Join (Select id as sid, fname, lname, fusion_id, doj from signin) yy on (xx.agent_id=yy.sid) Left join (Select fd_id, note as agent_note, date(entry_date) as agent_rvw_date from qa_vrs_cavalry_agent_rvw) zz on (xx.id=zz.fd_id) Left Join (Select fd_id as mgnt_fd_id, note as mgnt_note, date(entry_date) as mgnt_rvw_date, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as mgnt_name from qa_vrs_cavalry_mgnt_rvw) ww on (xx.id=ww.mgnt_fd_id) where xx.id not in (select fd_id from qa_vrs_lm_agent_rvw)";
		$query = $this->db->query($qSql);
		return $query->result_array();
	}
	

	
	//**************************************************************************************************//
	//********************************* VRS JAMAICA RIGHT PARTY AUDIT  *********************************//
	//**************************************************************************************************//
		public function get_vrs_jrpa_data($field_array) 
    {		
		$from_date= $field_array['from_date'];
		$to_date= $field_array['to_date'];	
		$current_user= $field_array['current_user'];	
		$cond="";
		
		if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date' ) ";
		
		if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
			$ops_cond=" Where (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
		}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
			$ops_cond=" Where assigned_to='$current_user'";
		}else{
			$ops_cond="";
		}
		
		$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name from qa_vrs_jrpa_feedback $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, doj, assigned_to from signin) yy on (xx.agent_id=yy.sid) Left join (Select fd_id, note as agent_note, date(entry_date) as agent_rvw_date from qa_vrs_jrpa_agent_rvw) zz on (xx.id=zz.fd_id) Left Join (Select fd_id as mgnt_fd_id, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as mgnt_name, note as mgnt_note, date(entry_date) as mgnt_rvw_date from qa_vrs_jrpa_mgnt_rvw) ww on (xx.id=ww.mgnt_fd_id) $ops_cond order by audit_date";
		$query = $this->db->query($qSql);
		return $query->result_array();
	}
	
	public function view_vrs_jrpa_feedback($_id)
	{
		$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name from qa_vrs_jrpa_feedback where id='$_id') xx Left Join (Select id as sid, fname, lname, fusion_id, doj from signin) yy on (xx.agent_id=yy.sid)";
		$query = $this->db->query($qSql);
		return $query->result_array();
	}
	
	public function view_mgnt_vrs_jrpa_rvw($_id)
	{
		$qSql="Select * FROM qa_vrs_jrpa_mgnt_rvw where fd_id='$_id'";
		$query = $this->db->query($qSql);
		return $query->row_array();
	}
	
	public function view_agent_vrs_jrpa_rvw($_id)
	{
		$qsql="Select * FROM qa_vrs_jrpa_agent_rvw where fd_id='$_id'";
		$query = $this->db->query($qsql);
		return $query->row_array();
	}
	
	public function get_agent_jrpa_review_data($field_array) 
    {
		$from_date= $field_array['from_date'];
		$to_date= $field_array['to_date'];		
		$current_user= $field_array['current_user'];
		$cond="";
		
		if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date' ) ";
		
		$qSql = "SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name from qa_vrs_jrpa_feedback $cond and agent_id='$current_user' And audit_type!='Calibration') xx Left Join (Select id as sid, fname, lname, fusion_id, doj from signin) yy on (xx.agent_id=yy.sid) Left join (Select fd_id, note as agent_note, date(entry_date) as agent_rvw_date from qa_vrs_jrpa_agent_rvw) zz on (xx.id=zz.fd_id) Left Join (Select fd_id as mgnt_fd_id, note as mgnt_note, date(entry_date) as mgnt_rvw_date, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as mgnt_name from qa_vrs_jrpa_mgnt_rvw) ww on (xx.id=ww.mgnt_fd_id)";
		$query = $this->db->query($qSql);
		return $query->result_array(); 
	}
		
	public function get_agent_not_jrpa_review_data($current_user)
    {
	    $qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name from qa_vrs_jrpa_feedback where agent_id='$current_user' And audit_type!='Calibration') xx Left Join (Select id as sid, fname, lname, fusion_id, doj from signin) yy on (xx.agent_id=yy.sid) Left join (Select fd_id, note as agent_note, date(entry_date) as agent_rvw_date from qa_vrs_jrpa_agent_rvw) zz on (xx.id=zz.fd_id) Left Join (Select fd_id as mgnt_fd_id, note as mgnt_note, date(entry_date) as mgnt_rvw_date, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as mgnt_name from qa_vrs_jrpa_mgnt_rvw) ww on (xx.id=ww.mgnt_fd_id) where xx.id not in (select fd_id from qa_vrs_jrpa_agent_rvw)";
		$query = $this->db->query($qSql);
		return $query->result_array();
	}
	
	
	/*--------------------------------VRS RP ANALYSIS----------------------------------------*/
	public function get_vrs_rp_analysis_data($field_array) 
    {		
		$from_date= $field_array['from_date'];
		$to_date= $field_array['to_date'];	
		$current_user= $field_array['current_user'];	
		$cond="";
		
		if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date' ) ";
		
		if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
			$ops_cond=" Where (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
		}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
			$ops_cond=" Where assigned_to='$current_user'";
		}else{
			$ops_cond="";
		}
		
		//$qSql = "SELECT * from
		//		(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name from qa_vrs_rp_analysis_feedback $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, doj, assigned_to from signin) yy on (xx.agent_id=yy.sid) Left join (Select fd_id, note as agent_note, date(entry_date) as agent_rvw_date from qa_vrs_rp_analysis_agent_rvw) zz on (xx.id=zz.fd_id) Left Join (Select fd_id as mgnt_fd_id, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as mgnt_name, note as mgnt_note, date(entry_date) as mgnt_rvw_date from qa_vrs_rp_analysis_mgnt_rvw) ww on (xx.id=ww.mgnt_fd_id) $ops_cond order by audit_date";
		$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name
				from qa_vrs_rp_analysis_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, doj, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
		$query = $this->db->query($qSql);
		return $query->result_array();
	}
	
	public function view_vrs_rp_analysis_feedback($_id)
	{
		//$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name from qa_vrs_rp_analysis_feedback where id='$_id') xx Left Join (Select id as sid, fname, lname, fusion_id, doj from signin) yy on (xx.agent_id=yy.sid)";
		$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name,agent_rvw_note as agent_note,mgnt_rvw_note as mgnt_note from qa_vrs_rp_analysis_feedback where id=$_id) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id,doj, assigned_to from signin) yy on (xx.agent_id=yy.sid)  order by audit_date";
		$query = $this->db->query($qSql);
		return $query->result_array();
	}
	
	
	
	/* public function get_agent_rp_analysis_review_data($field_array) 
    {
		$from_date= $field_array['from_date'];
		$to_date= $field_array['to_date'];		
		$current_user= $field_array['current_user'];
		$cond="";
		
		if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date' ) ";
		
		$qSql = "SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name from qa_vrs_rp_analysis_feedback $cond and agent_id='$current_user' And audit_type!='Calibration') xx Left Join (Select id as sid, fname, lname, fusion_id, doj from signin) yy on (xx.agent_id=yy.sid) Left join (Select fd_id, note as agent_note, date(entry_date) as agent_rvw_date from qa_vrs_rp_analysis_agent_rvw) zz on (xx.id=zz.fd_id) Left Join (Select fd_id as mgnt_fd_id, note as mgnt_note, date(entry_date) as mgnt_rvw_date, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as mgnt_name from qa_vrs_rp_analysis_mgnt_rvw) ww on (xx.id=ww.mgnt_fd_id)";
		$query = $this->db->query($qSql);
		return $query->result_array(); 
	} */
	
	
	/* public function get_agent_not_rp_analysis_review_data($current_user)
    {
		$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name from qa_vrs_rp_analysis_feedback where agent_id='$current_user' And audit_type!='Calibration') xx Left Join (Select id as sid, fname, lname, fusion_id, doj from signin) yy on (xx.agent_id=yy.sid) Left join (Select fd_id, note as agent_note, date(entry_date) as agent_rvw_date from qa_vrs_rp_analysis_agent_rvw) zz on (xx.id=zz.fd_id) Left Join (Select fd_id as mgnt_fd_id, note as mgnt_note, date(entry_date) as mgnt_rvw_date, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as mgnt_name from qa_vrs_rp_analysis_mgnt_rvw) ww on (xx.id=ww.mgnt_fd_id) where xx.id not in (select fd_id from qa_vrs_rp_analysis_agent_rvw)";
		$query = $this->db->query($qSql);
		return $query->result_array();
	} */
	
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
	
//////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////QA VRS REPORT///////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////

	public function qa_vrs_report_model($field_array){
		
		if($this->RepDB==null) $this->set_report_database();
		
		$date_from = $field_array['date_from'];
		$date_to = $field_array['date_to'];
		//$office_id = $field_array['office_id'];
		$pValue = $field_array['process_id'];
		$current_user = $field_array['current_user'];
		$cond="";
		
		
		if($date_from !="" && $date_to!=="" )  $cond= " Where (audit_date >= '$date_from' and audit_date <= '$date_to' ) ";
		
		//if($office_id!="") $cond1 = " Where office_id='$office_id'";
		
		if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
			$ops_cond=" Where (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
		}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
			$ops_cond=" Where assigned_to='$current_user'";
		}else{
			$ops_cond="";
		}
		
		if($pValue=='Right Party'){
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, time(entry_date) as entry_time from qa_vrs_rp_feedback $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, doj, assigned_to from signin) yy on (xx.agent_id=yy.sid) Left join (Select fd_id, note as agent_note, date(entry_date) as agent_rvw_date from qa_vrs_rp_agent_rvw) zz on (xx.id=zz.fd_id) Left Join (Select fd_id as mgnt_fd_id, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as mgnt_name, note as mgnt_note, date(entry_date) as mgnt_rvw_date from qa_vrs_rp_mgnt_rvw) ww on (xx.id=ww.mgnt_fd_id) $ops_cond order by audit_date";
			$query = $this->RepDB->query($qSql);
			return $query->result_array();
		
		}else if($pValue=='Left Message'){
		   $qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name,
				(select concat(fname, ' ', lname) as name from signin_client scx where scx.id=client_rvw_by) as client_rvw_name from qa_new_lm_feedback) xx Inner Join
				(Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_ids(id) as process_id, get_process_names(id) as process, doj, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on (xx.agent_id=yy.sid) $cond $ops_cond order by audit_date";
			
			$query = $this->RepDB->query($qSql);
			return $query->result_array();
		
		}else if($pValue=='Cavalry'){
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name from qa_vrs_cavalry_feedback $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, doj, assigned_to from signin) yy on (xx.agent_id=yy.sid) Left join (Select fd_id, note as agent_note, date(entry_date) as agent_rvw_date from qa_vrs_cavalry_agent_rvw) zz on (xx.id=zz.fd_id) Left Join (Select fd_id as mgnt_fd_id, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as mgnt_name, note as mgnt_note, date(entry_date) as mgnt_rvw_date from qa_vrs_cavalry_mgnt_rvw) ww on (xx.id=ww.mgnt_fd_id) $ops_cond order by audit_date";
			$query = $this->RepDB->query($qSql);
			return $query->result_array();
		
		}else if($pValue=='CPTA'){
			$qSql="SELECT cpta.audit_date, count(DISTINCT cpta.agent_id) as agent_audited, count(cpta.audit_date) as total_audit, count(cpta.connect_type) as no_connect, count(cpta.transfer) as no_transfer, (select count(connect_type) from qa_vrs_cpta_feedback vrs where vrs.connect_type='RP' and vrs.audit_date=cpta.audit_date) as rp_contact, (select count(verbatim) from qa_vrs_cpta_feedback vrs where vrs.verbatim='Yes' and vrs.audit_date=cpta.audit_date) as correct_verbatim,
			(select count(verbatim) from qa_vrs_cpta_feedback vrs where vrs.verbatim='No' and vrs.audit_date=cpta.audit_date) as incorrect_verbatim,
			(select count(transfer) from qa_vrs_cpta_feedback vrs where vrs.transfer='Correct' and vrs.audit_date=cpta.audit_date) as correct_transfer,
			(select count(transfer) from qa_vrs_cpta_feedback vrs where vrs.transfer='Incorrect' and vrs.audit_date=cpta.audit_date) as incorrect_transfer,
			(select count(transfer_type) from qa_vrs_cpta_feedback vrs where vrs.transfer_type='Warm' and vrs.audit_date=cpta.audit_date) as warm_transfer,
			(select count(transfer_type) from qa_vrs_cpta_feedback vrs where vrs.transfer_type='Cold' and vrs.audit_date=cpta.audit_date) as cold_transfer
			FROM qa_vrs_cpta_feedback cpta $cond group by audit_date";
			//echo $qSql;
			$query = $this->RepDB->query($qSql);
			return $query->result_array();
			
		}elseif($pValue=='JRPA'){
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, time(entry_date) as entry_time from qa_vrs_jrpa_feedback $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, doj, assigned_to from signin) yy on (xx.agent_id=yy.sid) Left join (Select fd_id, note as agent_note, date(entry_date) as agent_rvw_date from qa_vrs_jrpa_agent_rvw) zz on (xx.id=zz.fd_id) Left Join (Select fd_id as mgnt_fd_id, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as mgnt_name, note as mgnt_note, date(entry_date) as mgnt_rvw_date from qa_vrs_jrpa_mgnt_rvw) ww on (xx.id=ww.mgnt_fd_id) $ops_cond order by audit_date";
			$query = $this->RepDB->query($qSql);
			return $query->result_array();
		
		}else if($pValue=='Analysis'){
			
			//$qSql="SELECT * from
			//	(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, time(entry_date) as entry_time from qa_vrs_rp_analysis_feedback $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, doj, assigned_to from signin) yy on (xx.agent_id=yy.sid) Left join (Select fd_id, note as agent_note, date(entry_date) as agent_rvw_date from qa_vrs_rp_analysis_agent_rvw) zz on (xx.id=zz.fd_id) Left Join (Select fd_id as mgnt_fd_id, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as mgnt_name, note as mgnt_note, date(entry_date) as mgnt_rvw_date from qa_vrs_rp_analysis_mgnt_rvw) ww on (xx.id=ww.mgnt_fd_id) $ops_cond order by audit_date";
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name
				from qa_vrs_rp_analysis_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			
			
			$query = $this->RepDB->query($qSql);
			return $query->result_array();
		
		}
		
	}
	public function view_mgnt_vrs_cav_rvw($_id)
	{
		$qSql="Select * FROM qa_vrs_cavalry_mgnt_rvw where fd_id='$_id'";
		$query = $this->db->query($qSql);
		return $query->row_array();
	}
	
	public function view_agent_vrs_cav_rvw($_id)
	{
		$qsql="Select * FROM qa_vrs_cavalry_agent_rvw where fd_id='$_id'";
		$query = $this->db->query($qsql);
		return $query->row_array();
	}
	
	
	
	
}
?>	