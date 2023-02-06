<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Questions_model extends CI_Model {
    
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // CHECK USER CREDENTIALS
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
   	
	private $RepDB=null;
	
	public function set_report_database($group="default"){	
        $this->RepDB = $this->load->database($group,TRUE);
	}
	
	
	 public function get_questions($limit, $start) 
	{
        $this->db->limit($limit, $start);
        $query = $this->db->get("pkt_questions");
        return $query->result();
    }
}

?>