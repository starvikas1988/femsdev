<?php
class Qa_agent_score_comparison_boomsourcing extends CI_Controller{
    
    function __construct() {
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->model('user_model');
		$this->load->model('Common_model');
	}

    public function index(){
        if(check_logged_in()){
            $data['aside_template'] = "qa_boomsourcing_aside/aside.php";
            $data['content_template'] = "qa_agent_score_comparison_boomsourcing/index.php";
            $data['content_js'] = "qa_agent_score_comparison_boomsourcing/qa_agent_score_comparison_boomsourcing_js.php";

            $data['office_location'] = $this->Common_model->get_office_location_list();
            
            $data['campaign_list'] = $this->db->query("SELECT table_name FROM qa_boomsourcing_defect WHERE is_active=1")->result_array();

            $this->load->view("dashboard", $data);
        }
    }

    //Search API
    public function search(){
        if(check_logged_in()){
            $campaign = $this->input->post("campaign");
            $from_date = $this->input->post("from_date");
            $to_date = $this->input->post("to_date");
            $search_box = $this->input->post("search_box");
        

            if($search_box==2){
                //$office = $this->input->post('office');
                $cond1 = $cond2 = "";
                $campaign1 = $this->input->post("campaign1");
                $from_date1 = $this->input->post("from_date1");
                $to_date1 = $this->input->post("to_date1");
                $office1 = $this->input->post('office1');

                $office = explode(",", $this->input->post('office'));
                if($office!=""){
                    $value = array_search('ALL', $office);
                    if($value==''){
                        $office_id=implode("','", $office);
                        $cond1 .=" AND s.office_id in ('$office_id')";
                    }else{
                        $office_id='';
                        $cond1 = '';
                    }
                }
          

                //Data Set 2
                $sql2 = "SELECT qa.agent_id, s.xpoid, CONCAT(s.fname, ' ', s.lname) as agent_name, AVG(qa.overall_score) as average_score FROM $campaign qa LEFT JOIN signin s ON qa.agent_id=s.id WHERE qa.audit_date >= '$from_date' AND qa.audit_date <= '$to_date'$cond1 GROUP BY agent_name ORDER BY agent_name";

                $json_array['sql_2'] = $sql2;

                $json_array['data_set2'] = $this->db->query($sql2)->result_array();

                //Data Set 1
                $sql1 = "SELECT qa.agent_id, s.xpoid, CONCAT(s.fname, ' ', s.lname) as agent_name, AVG(qa.overall_score) as average_score FROM $campaign1 qa LEFT JOIN signin s ON qa.agent_id=s.id WHERE qa.audit_date >= '$from_date1' AND qa.audit_date <= '$to_date1'$cond1 GROUP BY agent_name ORDER BY agent_name";

                $json_array['sql_1'] = $sql1;

                $json_array['data_set1'] = $this->db->query($sql1)->result_array();

                $json_array['data_set_count'] = 2;
            }else{
                $cond1="";
                $office = explode(",", $this->input->post('office'));
                if($office!=""){
                    $value = array_search('ALL', $office);
                    if($value==''){
                        $office_id=implode("','", $office);
                        $cond1 .=" AND s.office_id in ('$office_id')";
                    }else{
                        $office_id='';
                        $cond1 = '';
                    }
                }

                $sql = "SELECT qa.agent_id, s.xpoid, CONCAT(s.fname, ' ', s.lname) as agent_name, AVG(qa.overall_score) as average_score FROM $campaign qa LEFT JOIN signin s ON qa.agent_id=s.id WHERE qa.audit_date >= '$from_date' AND qa.audit_date <= '$to_date'$cond1 GROUP BY agent_name ORDER BY agent_name";

                $json_array['sql_1'] = $sql;

                $json_array['data_set1'] = $this->db->query($sql)->result_array();

                $json_array['data_set_count'] = 1;
            }
            echo json_encode($json_array);
        }
    }
}
?>