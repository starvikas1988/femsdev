<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hierarchy extends CI_Controller {

   
    /////////////////////////////////////////////////////////////////////////////////////////////
    // HEIRARCHY PAGE
    /////////////////////////////////////////////////////////////////////////////////////////////
    
	 function __construct() {
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
	 }
	 
    public function index()
    {
		if(check_logged_in()){
		  
		  $_SESSION['pmenu'] = "1";

		  //$data["aside_template"] = "hierarchy/aside.php";
		  //$data["content_template"] = "hierarchy/organisation.php";
		  redirect(base_url()."hierarchy/myupteam","refresh");
		  
		}
    }
	
	
	public function myupteam()
    {
		if(check_logged_in()){
		  
		  $_SESSION['pmenu'] = "3";
		  $getdata = "ok";
		  
		  $user_site_id= get_user_site_id();
		  $srole_id= get_role_id();
		  $current_user = get_user_id();
		  $ses_dept_id=get_dept_id();
		  $user_office_id=get_user_office_id();
		  $is_global_access=get_global_access();
		  $databuffer = $this->input->get('buffer');
		  
		  $current_uid = $current_user;$sl=0;
		  //$current_uid = "7";
		  
		  $mydetails = $data['mydetails'] = $this->get_each_user_data($current_uid);
		  $current_assigned_to = $current_uid;
		  $current_depid = $mydetails['depid'];
		  
		  while(!empty($current_assigned_to))
		  {
			  $sl++;
			  
			  // PROFILE IMAGE CAPTURE
			  //CASE WHEN s.pic_ext <> '' THEN concat('".base_url() ."pimgs/',s.fusion_id,'/',s.fusion_id,'.',s.pic_ext) ELSE concat('".base_url() ."pimgs/blank.png') END as photo,
			  
			  
			  // GET MY DATA
			  $sqlroles = "SELECT s.id,s.fusion_id,s.xpoid,concat(s.fname,' ',s.lname) as fullname,s.sex, s.assigned_to,  a.lpname as assigned_name, 
			  d.depid, d.d_fullname, c.cid, c.c_fullname, p.pid, p.p_fullname, o.office_name, o.shortform as office_short,r.rid as roleids, r.rolename as rolename, rg.roid as roleorgid, rg.roleorgname as roleorgname, (SELECT count(*) from signin WHERE assigned_to = s.id) as team, concat('".base_url() ."pimgs/blank.png') as photo, '$sl' as level
			  from signin as s
			  LEFT JOIN (SELECT id as depid, description as d_fullname, shname as d_shortname from department) as d ON d.depid = s.dept_id
			  LEFT JOIN (SELECT id as cid, shname as c_shortname, fullname as c_fullname from client) as c ON c.cid = s.client_id
			  LEFT JOIN (SELECT id as pid, name as p_fullname from process) as p ON p.pid = s.process_id
			  LEFT JOIN (SELECT abbr as shortform, office_name from office_location) as o ON o.shortform = s.office_id
			  LEFT JOIN (SELECT id as lid, concat(fname, ' ', lname) as lpname from signin) as a ON a.lid = s.assigned_to
			  LEFT JOIN (SELECT id as rid, name as rolename from role) as r ON r.rid = s.role_id
			  LEFT JOIN (SELECT id as roid, name as roleorgname from role_organization) as rg ON rg.roid = s.org_role_id
			  WHERE s.id = '$current_assigned_to'";
			  $queryroles = $this->Common_model->get_query_row_array($sqlroles);
			  $data['teamdata'][$current_assigned_to] = $queryroles;
			  
			  // SET ASSIGNED TO DATA
			  $current_assigned_to = $queryroles['assigned_to']; 
		  
			  // GET LEVEL WISE DATA
			  if(empty($current_assigned_to)){ 
			  
				  $current_assigned_to = ""; $current_id = $queryroles['id'];
				  $sqllevelr = "SELECT s.id,s.fusion_id,s.xpoid,concat(s.fname,' ',s.lname) as fullname,s.sex, s.assigned_to,  a.lpname as assigned_name, 
				  d.depid, d.d_fullname, c.cid, c.c_fullname, p.pid, p.p_fullname, o.office_name, o.shortform as office_short,r.rid as roleids, r.rolename as rolename, rg.roid as roleorgid, rg.roleorgname as roleorgname, (SELECT count(*) from signin WHERE assigned_to = s.id) as team, 
				  concat('".base_url() ."pimgs/blank.png') as photo, '$sl' as level
				  from signin as s
				  LEFT JOIN (SELECT id as depid, description as d_fullname, shname as d_shortname from department) as d ON d.depid = s.dept_id
				  LEFT JOIN (SELECT id as cid, shname as c_shortname, fullname as c_fullname from client) as c ON c.cid = s.client_id
				  LEFT JOIN (SELECT id as pid, name as p_fullname from process) as p ON p.pid = s.process_id
				  LEFT JOIN (SELECT abbr as shortform, office_name from office_location) as o ON o.shortform = s.office_id
				  LEFT JOIN (SELECT id as lid, concat(fname, ' ', lname) as lpname from signin) as a ON a.lid = s.assigned_to
				  LEFT JOIN (SELECT id as rid, name as rolename from role) as r ON r.rid = s.role_id
				  LEFT JOIN (SELECT id as roid, name as roleorgname from role_organization) as rg ON rg.roid = s.org_role_id
				  WHERE s.id = '$current_id'";
				  
			  } else {
				  
				  $sqllevelr = "SELECT s.id,s.fusion_id,s.xpoid,concat(s.fname,' ',s.lname) as fullname,s.sex, s.assigned_to,  a.lpname as assigned_name, 
				  d.depid, d.d_fullname, c.cid, c.c_fullname, p.pid, p.p_fullname, o.office_name, o.shortform as office_short,r.rid as roleids, r.rolename as rolename, rg.roid as roleorgid, rg.roleorgname as roleorgname, (SELECT count(*) from signin WHERE assigned_to = s.id) as team, 
				  concat('".base_url() ."pimgs/blank.png') as photo, '$sl' as level
				  from signin as s
				  LEFT JOIN (SELECT id as depid, description as d_fullname, shname as d_shortname from department) as d ON d.depid = s.dept_id
				  LEFT JOIN (SELECT id as cid, shname as c_shortname, fullname as c_fullname from client) as c ON c.cid = s.client_id
				  LEFT JOIN (SELECT id as pid, name as p_fullname from process) as p ON p.pid = s.process_id
				  LEFT JOIN (SELECT abbr as shortform, office_name from office_location) as o ON o.shortform = s.office_id
				  LEFT JOIN (SELECT id as lid, concat(fname, ' ', lname) as lpname from signin) as a ON a.lid = s.assigned_to
				  LEFT JOIN (SELECT id as rid, name as rolename from role) as r ON r.rid = s.role_id
				  LEFT JOIN (SELECT id as roid, name as roleorgname from role_organization) as rg ON rg.roid = s.org_role_id
				  WHERE s.assigned_to = '$current_assigned_to' AND (d.depid = '$current_depid')";
				  
			  }
		      
			  $querylevelr = $this->Common_model->get_query_result_array($sqllevelr);
			  
			  $current_depid = $queryroles['depid'];
			  $data['leveldata'][$sl] = $querylevelr;
			  //$data['leveldata'][$sl][$current_assigned_to] = $queryroles;
			  
		  }
		  
		  $data['colorlight'] = array("#ce93d8","#ce93d8","#f48fb1","#90caf9","#80cbc4","#c5e1a5","#ffe082","#c5e1a5","#ffe082");
		  $data['colordark'] = array("#ba68c8","#ba68c8","#f06292","#64b5f6","#4db6ac","#aed581","#ffd54f","#c5e1a5","#ffe082");
		  
		  //echo "<pre>".print_r($data,true) ."</pre>"; die();
	      $data['totallevels'] = $sl;
		  $data["aside_template"] = "hierarchy/aside.php";
		  $data["content_template"] = "hierarchy/myupteam.php";
		  $this->load->view('dashboard',$data);
		  
		}
    }
	
	
	
	public function getdownline()
    {
		if(check_logged_in()){
		  
		  // TABLE WISE - ALL TEAM NESTING
		  $getdata = "ok";
		  
		  $user_site_id= get_user_site_id();
		  $srole_id= get_role_id();
		  $current_user = get_user_id();
		  $ses_dept_id=get_dept_id();
		  $user_office_id=get_user_office_id();
		  $is_global_access=get_global_access();
		  $databuffer = $this->input->get('buffer');
		  
		  $current_uid = $current_user;
		  $current_uid = $this->input->get('uid');
		  
		  $data['parentdetails'] = $this->get_each_user_data($current_uid);
		  
		  $sqlroles = "SELECT s.id,s.fusion_id,s.xpoid,concat(s.fname,' ',s.lname) as fullname,s.sex, s.assigned_to,  a.lpname as assigned_name, 
		  d.depid, d.d_fullname, c.cid, c.c_fullname, p.pid, p.p_fullname, o.office_name, o.shortform as office_short,r.rid as roleids, r.rolename as rolename, rg.roid as roleorgid, rg.roleorgname as roleorgname, (SELECT count(*) from signin WHERE assigned_to = s.id) as team, 
		  concat('".base_url() ."pimgs/blank.png') as photo 
		  from signin as s
		  LEFT JOIN (SELECT id as depid, description as d_fullname, shname as d_shortname from department) as d ON d.depid = s.dept_id
		  LEFT JOIN (SELECT id as cid, shname as c_shortname, fullname as c_fullname from client) as c ON c.cid = s.client_id
		  LEFT JOIN (SELECT id as pid, name as p_fullname from process) as p ON p.pid = s.process_id
		  LEFT JOIN (SELECT abbr as shortform, office_name from office_location) as o ON o.shortform = s.office_id
		  LEFT JOIN (SELECT id as lid, concat(fname, ' ', lname) as lpname from signin) as a ON a.lid = s.assigned_to
		  LEFT JOIN (SELECT id as rid, name as rolename from role) as r ON r.rid = s.role_id
		  LEFT JOIN (SELECT id as roid, name as roleorgname from role_organization) as rg ON rg.roid = s.org_role_id
		  WHERE assigned_to = '$current_uid'";
		  $queryroles = $data['folder'] = $this->Common_model->get_query_result_array($sqlroles);
		  
		  $data['colorlight'] = array("#ce93d8","#ce93d8","#f48fb1","#90caf9","#80cbc4","#c5e1a5","#ffe082","#c5e1a5","#ffe082");
		  $data['colordark'] = array("#ba68c8","#ba68c8","#f06292","#64b5f6","#4db6ac","#aed581","#ffd54f","#c5e1a5","#ffe082");
		  
		  //echo "<pre>".print_r($data,true) ."</pre>"; die();
	
		  $this->load->view('hierarchy/getmyallteam', $data);
		  //$this->load->view('jscripts/hierarchy/myallteam_js', $data);
		  
		}
    }
	
	

	
	
###############################################################################################
##
##------------------------- JS CHARTING -----------------------------------------------------
##
###############################################################################################	
	
	
	
	public function organisation()
    {
		if(check_logged_in()){
		  
		   // JS CHARTING --- MY ORGANISATION
		   
		  $_SESSION['pmenu'] = "1";
		  $data['orgchart'] = "1";
		  
		  $databuffer = $this->input->get('buffer');
		  
		  // GET ROLES
		  $sqlroles = "SELECT distinct(controller) as name from role_organization ORDER by rank,id";
		  $queryroles = $data['folder'] = $this->Common_model->get_query_result_array($sqlroles);
		  
		  foreach($queryroles as $eacht)
		  {
			  $namec = $eacht['name'];
			  $sqlroleorg = "SELECT * from role_organization WHERE is_active = '1' AND controller = '$namec' ORDER by rank,id";
			  $queryroleorg = $data['folderd'][$namec] = $this->Common_model->get_query_result_array($sqlroleorg);
		  }
		  
		  $data['colorlight'] = array("#ce93d8","#ce93d8","#f48fb1","#90caf9","#80cbc4","#c5e1a5","#ffe082","#c5e1a5","#ffe082");
		  $data['colordark'] = array("#ba68c8","#ba68c8","#f06292","#64b5f6","#4db6ac","#aed581","#ffd54f","#c5e1a5","#ffe082");
		  
		  // GET ROLE ORGANISATION
		  $sqlroleo = "SELECT * from role_organization WHERE is_active = '1' ORDER by rank,id,controller";
		  $queryroleorganisation = $data['organisation'] = $this->Common_model->get_query_result_array($sqlroleo);
		  
		  //echo "<pre>".print_r($data,true) ."</pre>"; die();
	
		  $data["aside_template"] = "hierarchy/aside.php";
		  $data["content_template"] = "hierarchy/organisation.php";
		  $this->load->view('dashboard',$data);
		  
		}
    }
	
	
	public function myteam()
    {
		if(check_logged_in()){
		  
		  // JS CHARTING --- MY TEAM
		  
		  $_SESSION['pmenu'] = "2";
		  $data['orgchart'] = "2";
		  $getdata = "ok";
		  
		  $user_site_id= get_user_site_id();
		  $srole_id= get_role_id();
		  $current_user = get_user_id();
		  $ses_dept_id=get_dept_id();
		  $user_office_id=get_user_office_id();
		  $is_global_access=get_global_access();
		  $databuffer = $this->input->get('buffer');
		  
		  $current_uid = $current_user;
		  //$current_uid = "6597";
		  
		  $sqlroles = "SELECT s.id,s.fusion_id,s.xpoid,concat(s.fname,' ',s.lname) as fullname,s.sex, s.assigned_to,  a.lpname as assigned_name, 
		  d.depid, d.d_fullname, c.cid, c.c_fullname, p.pid, p.p_fullname, o.office_name, o.shortform as office_short,r.rid, r.rolename, rg.roid, rg.roleorgname
		  from signin as s
		  LEFT JOIN (SELECT id as depid, description as d_fullname, shname as d_shortname from department) as d ON d.depid = s.dept_id
		  LEFT JOIN (SELECT id as cid, shname as c_shortname, fullname as c_fullname from client) as c ON c.cid = s.client_id
		  LEFT JOIN (SELECT id as pid, name as p_fullname from process) as p ON p.pid = s.process_id
		  LEFT JOIN (SELECT abbr as shortform, office_name from office_location) as o ON o.shortform = s.office_id
		  LEFT JOIN (SELECT id as lid, concat(fname, ' ', lname) as lpname from signin) as a ON a.lid = s.assigned_to
		  LEFT JOIN (SELECT id as rid, name as rolename from role) as r ON r.rid = s.role_id
		  LEFT JOIN (SELECT id as roid, name as roleorgname from role_organization) as rg ON rg.roid = s.org_role_id
		  WHERE id = '$current_uid'";
		  $queryroles = $data['folder'] = $this->Common_model->get_query_row_array($sqlroles);
		  $total_uid = NULL;
		  $total_uid[] = $current_uid;
		  $getnextlist = $current_uid;
		  
		  while($getdata != "stop")
		  {
			  $search_uid = NULL;
			  
			  //FLAG CHECK
			  $sqlc = "SELECT id as uid from signin WHERE assigned_to IN ($getnextlist)";
			  $queryc = $this->Common_model->get_query_result_array($sqlc);
			  $totalc = count($queryc);
			  if($totalc > 0)
		      {
				  $getnextlist = "";
				  foreach($queryc as $tokenu)
				  {
					  $total_uid[] = $tokenu['uid'];
					  $search_uid[] = $tokenu['uid'];
				  }
				  $getdata = "ok";
				  $getnextlist = implode(',',$search_uid);
			  }
			  else 
			  {
				$getdata = "stop"; 
			  }
			  
		  }
		  
		  $getdlist = implode(',',$total_uid);
		  $udetails = $data['users'] = $this->get_user_data($getdlist);
		  
		  $data['colorlight'] = array("#ce93d8","#ce93d8","#f48fb1","#90caf9","#80cbc4","#c5e1a5","#ffe082","#c5e1a5","#ffe082");
		  $data['colordark'] = array("#ba68c8","#ba68c8","#f06292","#64b5f6","#4db6ac","#aed581","#ffd54f","#c5e1a5","#ffe082");
		  
		  //$finalsenddata = $data['csvdata'] = $this->getCSVusers($udetails);
		  $finalsenddata = $data['csvdata'] = json_encode($udetails);
		  
		  //echo "<pre>".print_r($data,true) ."</pre>"; die();
	
		  $data["aside_template"] = "hierarchy/aside.php";
		  $data["content_template"] = "hierarchy/myteam.php";
		  $this->load->view('dashboard',$data);
		  
		}
    }
	
	
	public function myallteam()
    {
		if(check_logged_in()){
		  
		  // TABLE WISE - ALL TEAM NESTING
		  
		  $_SESSION['pmenu'] = "2";
		  $data['orgchart'] = "2";
		  $getdata = "ok";
		  
		  $user_site_id= get_user_site_id();
		  $srole_id= get_role_id();
		  $current_user = get_user_id();
		  $ses_dept_id=get_dept_id();
		  $user_office_id=get_user_office_id();
		  $is_global_access=get_global_access();
		  $databuffer = $this->input->get('buffer');
		  
		  $current_uid = $current_user;
		  //$current_uid = "6458";
		  
		  $data['parentdetails'] = $this->get_each_user_data($current_uid);
		  
		  $sqlroles = "SELECT s.id,s.fusion_id,s.xpoid,concat(s.fname,' ',s.lname) as fullname,s.sex, s.assigned_to,  a.lpname as assigned_name, 
		  d.depid, d.d_fullname, c.cid, c.c_fullname, p.pid, p.p_fullname, o.office_name, o.shortform as office_short,r.rid as roleids, r.rolename as rolename, rg.roid as roleorgid, rg.roleorgname as roleorgname, (SELECT count(*) from signin WHERE assigned_to = s.id) as team, 
		  concat('".base_url() ."pimgs/blank.png') as photo 
		  from signin as s
		  LEFT JOIN (SELECT id as depid, description as d_fullname, shname as d_shortname from department) as d ON d.depid = s.dept_id
		  LEFT JOIN (SELECT id as cid, shname as c_shortname, fullname as c_fullname from client) as c ON c.cid = s.client_id
		  LEFT JOIN (SELECT id as pid, name as p_fullname from process) as p ON p.pid = s.process_id
		  LEFT JOIN (SELECT abbr as shortform, office_name from office_location) as o ON o.shortform = s.office_id
		  LEFT JOIN (SELECT id as lid, concat(fname, ' ', lname) as lpname from signin) as a ON a.lid = s.assigned_to
		  LEFT JOIN (SELECT id as rid, name as rolename from role) as r ON r.rid = s.role_id
		  LEFT JOIN (SELECT id as roid, name as roleorgname from role_organization) as rg ON rg.roid = s.org_role_id
		  WHERE assigned_to = '$current_uid'";
		  $queryroles = $data['folder'] = $this->Common_model->get_query_result_array($sqlroles);
		  
		  $data['colorlight'] = array("#ce93d8","#ce93d8","#f48fb1","#90caf9","#80cbc4","#c5e1a5","#ffe082","#c5e1a5","#ffe082");
		  $data['colordark'] = array("#ba68c8","#ba68c8","#f06292","#64b5f6","#4db6ac","#aed581","#ffd54f","#c5e1a5","#ffe082");
		  
		  //$finalsenddata = $data['csvdata'] = json_encode($udetails);
		  
		  //echo "<pre>".print_r($data,true) ."</pre>"; die();
	
		  $data["aside_template"] = "hierarchy/aside.php";
		  $data["content_template"] = "hierarchy/myallteam.php";
		  $this->load->view('dashboard',$data);
		  
		}
    }
	
	


###############################################################################################
##
##------------------------- PRIVATE USEFULL FUNCTIONS ---------------------------------------
##
###############################################################################################		

	
	
	private function getCSVusers($udetails)
	{
		$data = "name,position,department,id,parent,number";
		foreach($udetails as $td)
		{
		  $data .= implode(',',$td);
		  //$data .= "<br/>";
		}
		return $data;
	}
	
	
	private function get_each_user_data($uid)
	{
		 $sqlroles = "SELECT s.id,s.fusion_id,s.xpoid,concat(s.fname,' ',s.lname) as fullname,s.sex, s.assigned_to,  a.lpname as assigned_name, 
		  d.depid, d.d_fullname, c.cid, c.c_fullname, p.pid, p.p_fullname, o.office_name, o.shortform as office_short,r.rid, r.rolename, rg.roid, rg.roleorgname
		  from signin as s
		  LEFT JOIN (SELECT id as depid, description as d_fullname, shname as d_shortname from department) as d ON d.depid = s.dept_id
		  LEFT JOIN (SELECT id as cid, shname as c_shortname, fullname as c_fullname from client) as c ON c.cid = s.client_id
		  LEFT JOIN (SELECT id as pid, name as p_fullname from process) as p ON p.pid = s.process_id
		  LEFT JOIN (SELECT abbr as shortform, office_name from office_location) as o ON o.shortform = s.office_id
		  LEFT JOIN (SELECT id as lid, concat(fname, ' ', lname) as lpname from signin) as a ON a.lid = s.assigned_to
		  LEFT JOIN (SELECT id as rid, name as rolename from role) as r ON r.rid = s.role_id
		  LEFT JOIN (SELECT id as roid, name as roleorgname from role_organization) as rg ON rg.roid = s.org_role_id
		  WHERE id IN ($uid)";
		  $queryroles = $data['folder'] = $this->Common_model->get_query_row_array($sqlroles);
		  return $queryroles;
	}
	
	
	private function get_user_data($uid)
	{
		 $urlg = base_url();
		 //concat('".$urlg ."pimgs/',s.fusion_id,'/',s.fusion_id,'.',s.pic_ext)
		 
		 $current_user = get_user_id();
		 //$current_user = "6597";
		 $sqlroles = "SELECT concat(s.fname,' ',s.lname) as name, r.rolename as position, d.d_fullname as department, s.id as id, 
		 CASE WHEN s.id = '$current_user' THEN '' ELSE s.assigned_to END as parent, s.fusion_id as number, concat('".$urlg ."pimgs/blank.png') as ext from signin as s
		  LEFT JOIN (SELECT id as depid, description as d_fullname, shname as d_shortname from department) as d ON d.depid = s.dept_id
		  LEFT JOIN (SELECT id as cid, shname as c_shortname, fullname as c_fullname from client) as c ON c.cid = s.client_id
		  LEFT JOIN (SELECT id as pid, name as p_fullname from process) as p ON p.pid = s.process_id
		  LEFT JOIN (SELECT abbr as shortform, office_name from office_location) as o ON o.shortform = s.office_id
		  LEFT JOIN (SELECT id as lid, concat(fname, ' ', lname) as lpname from signin) as a ON a.lid = s.assigned_to
		  LEFT JOIN (SELECT id as rid, name as rolename from role) as r ON r.rid = s.role_id
		  LEFT JOIN (SELECT id as roid, name as roleorgname from role_organization) as rg ON rg.roid = s.org_role_id
		  WHERE id IN ($uid)
		  ORDER by parent ASC";
		  $queryroles = $data['folder'] = $this->Common_model->get_query_result_array($sqlroles);
		  return $queryroles;
	}
	
	
	public function getallteam()
	{
		  
		  $uid = $this->input->get('uid');
		  $pid = $this->input->get('pid');
		  $parentdetails = $this->get_each_user_data($pid);
		  
		  $sqlroles = "SELECT s.id,s.fusion_id,s.xpoid,concat(s.fname,' ',s.lname) as fullname,s.sex, s.assigned_to,  a.lpname as assigned_name, 
		  d.depid, d.d_fullname, c.cid, c.c_fullname, p.pid, p.p_fullname, o.office_name, o.shortform as office_short,r.rid as roleids, r.rolename as rolename, rg.roid as roleorgid, rg.roleorgname as roleorgname, (SELECT count(*) from signin WHERE assigned_to = s.id) as team, 
		  concat('".base_url() ."pimgs/blank.png') as photo 
		  from signin as s
		  LEFT JOIN (SELECT id as depid, description as d_fullname, shname as d_shortname from department) as d ON d.depid = s.dept_id
		  LEFT JOIN (SELECT id as cid, shname as c_shortname, fullname as c_fullname from client) as c ON c.cid = s.client_id
		  LEFT JOIN (SELECT id as pid, name as p_fullname from process) as p ON p.pid = s.process_id
		  LEFT JOIN (SELECT abbr as shortform, office_name from office_location) as o ON o.shortform = s.office_id
		  LEFT JOIN (SELECT id as lid, concat(fname, ' ', lname) as lpname from signin) as a ON a.lid = s.assigned_to
		  LEFT JOIN (SELECT id as rid, name as rolename from role) as r ON r.rid = s.role_id
		  LEFT JOIN (SELECT id as roid, name as roleorgname from role_organization) as rg ON rg.roid = s.org_role_id
		  WHERE assigned_to = '$uid'";
		  $queryroles = $data['folder'] = $this->Common_model->get_query_result_array($sqlroles);
		  $sl = "0"; $dataset = "";
		  
		  $minusa = <<<MINUS
			  <a title="Close View" onclick="closeteam(this,'view{$parentdetails['id']}','moreteam{$parentdetails['id']}')">
				<i class="fa fa-minus-circle"></i></a>
MINUS;
		  
			echo $parent = <<<PAR
			<tr class="blurremovenow selectedtr" id="view{$parentdetails['id']}" class="selectedtr"><td>{$minusa}</td><td colspan="7">{$parentdetails['fullname']} - {$parentdetails['rolename']}</td></tr>
PAR;
		  
		  foreach($queryroles as $token)
		  {
			  $sl++;
			  $showa = "";  
			  $mytr = "finaltr"; $myteamt = "";
			  if($token['team']>0){ 
			  $mytr = "initialtrmore"; $myteamt = $token['team'];
				$showa = <<<SHOW
			  <a title="{$token['team']} Team" id="moreteam{$token['id']}" style="" parentid="{$token['id']}" parentname="{$token['fullname']}"  onclick="displayteam(this,{$token['id']})">
				<i class="fa fa-plus-circle"></i></a>
SHOW;
			  }
		    
				$dataset .= <<<CHECK
					<tr class="blurremovenow" id="view{$parentdetails['id']}" class="{$mytr}">
					<td>{$showa}</td>
					<td><img src="{$token['photo']}" width="20" /></td>
					<td>{$sl}</td>
					<td>{$token['fusion_id']}</td>
					<td class="increasesizetext">{$token['fullname']}</td>
					<td>{$token['rolename']}</td>
					<td>{$token['d_fullname']}</td>
					<td class="increasesize">{$myteamt}</td>
					</tr>
CHECK;			  
		 }
		 
		  echo $dataset;
		  
		  echo $parent = <<<PAREND
		    <tr class="blurremovenow" id="view{$parentdetails['id']}"><td style="padding:5px"></td><td colspan="7" style="padding:5px"></td></tr>
			<tr class="blurremovenow selectedtr" id="view{$parentdetails['id']}" class="selectedtr"><td></td><td colspan="7" style="padding:5px"></td></tr>
PAREND;		 
		  
	}
	
	
	
	
	
	
	
	
	
}
     