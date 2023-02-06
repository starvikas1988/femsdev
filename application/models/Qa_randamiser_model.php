<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Qa_randamiser_model extends CI_Model {
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


	
///////////////////////////////////////////
	function insert_excel($data){
		$this->db->insert_batch('qa_ss_sampling_randomiser', $data);
	}
	

	function bsnl_insert_excel($data){
		$this->db->insert_batch('qa_randamiser_bsnl_data', $data);
	}
	function insert_excel_upload($table,$data){
		$this->db->insert_batch($table, $data);
	}
}
?>	