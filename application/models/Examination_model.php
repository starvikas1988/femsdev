
<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Examination_model extends CI_Model {

 public function get_examination_type_list()
    {
        
		$qSql="Select id, examination_type_name from examination_types where status=1";
		$query = $this->db->query($qSql);
        return $query->row_array();
    }
    

}
    
?>