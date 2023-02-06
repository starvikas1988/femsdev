<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Qa_agent_coaching_model extends CI_Model {
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

	
	public function get_agent_id($cid,$pid,$apid)
	{	
		$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,$cid) and (is_assign_process (id,$pid) or is_assign_process (id,$apid)) and status=1  order by name";
		$query = $this->db->query($qSql);
		return $query->result_array();	
	}
	
	function agent_coaching_insert_excel($data){
		$this->db->insert_batch('qa_coaching_raw_feedback', $data);
	}
}
?>	