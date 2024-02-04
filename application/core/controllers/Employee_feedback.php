<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_feedback extends CI_Controller {

   
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
		if(check_logged_in())
        {
			$data['user_name'] = get_username();
			$data['user_id'] = $current_user_id = get_user_id();
			$data['department_name'] = get_deptname();
			$data['assigned_to_id'] = get_assigned_to();
			$data['current_quarter'] = $this->getQuarter(date('F'));
			
			$query = 'SELECT CONCAT(fname," ",lname) AS value FROM signin WHERE id="'.$data['assigned_to_id'].'"';
			$data['assigned_to_name'] = $this->Common_model->get_single_value($query);
			
			
			
			
			$data["content_template"] = "employee_feedback/index.php";
			$data["aside_template"] = "employee_feedback/aside.php";
			
			
			if($this->get_feedback_status($data['user_id']) > 0)
			{
				$data['FeedBackQuarter'] = date('Y').'-'.$this->getQuarter(date('F'));
				
				$sqldata = 'SELECT efp_performance.performance_id,
				department.description as department_name,
				efp_performance.added_for AS added_for_id,
				CONCAT(signin.fname," ",signin.lname) AS added_for,
				efp_performance.added_by AS added_by_id,
				CONCAT(added_by.fname," ",added_by.lname) AS added_by,
				efp_performance.overall_performance AS total_score,efp_performance.overall, efp_performance.year_quarter
				FROM efp_performance
				LEFT JOIN signin ON signin.id = efp_performance.added_for
                LEFT JOIN signin AS added_by ON added_by.id = efp_performance.added_by
                LEFT JOIN department ON department.id = added_by.dept_id
				WHERE efp_performance.added_by = "'.$current_user_id.'"
                ORDER BY efp_performance.year_quarter';
				$data['performancedata'] = $this->Common_model->get_query_result_array($sqldata);
				
				$data["content_template"] = "employee_feedback/done_employee_feedback.php";
			}
			
			if($data['assigned_to_id'] == 0)
			{
				$data["content_template"] = "employee_feedback/cant_employee_feedback.php";
				
			}
						
			$this->load->view('dashboard',$data);
		}
	}
	
	public function process_feedback()
    {
		$input_data = $this->input->post();
		
        $leadership = $input_data['leadership_1'].','.$input_data['leadership_2'].','.$input_data['leadership_3'].','.$input_data['leadership_4'].','.$input_data['leadership_5'];
        $work_knowledge = $input_data['work_knowledge_1'].','.$input_data['work_knowledge_2'].','.$input_data['work_knowledge_3'].','.$input_data['work_knowledge_4'].','.$input_data['work_knowledge_5'];
        $decision_making = $input_data['decision_making_1'].','.$input_data['decision_making_2'].','.$input_data['decision_making_3'].','.$input_data['decision_making_4'].','.$input_data['decision_making_5'];
        $communication = $input_data['communication_1'].','.$input_data['communication_2'].','.$input_data['communication_3'].','.$input_data['communication_4'].','.$input_data['communication_5'];
        $crisis = $input_data['crisis_1'].','.$input_data['crisis_2'].','.$input_data['crisis_3'].','.$input_data['crisis_4'].','.$input_data['crisis_5'];
        
        $query = $this->db->query('INSERT INTO efp_performance(location_id,year_quarter,leadership_scores,leadership_comment,work_knowledge_scores,work_knowledge_comment,decision_making_scores,decision_making_comment,communication_scores,communication_comment,crisis_scores,crisis_comment,overall,other_comments,added_by,added_for,leadership_performance,work_knowledge_performance,decision_making_performance,communication_performance,crisis_performance,overall_performance) VALUES( "'. $input_data['location_id'] .'", "'.date('Y').'-'.$this->getQuarter(date('F')).'","'.$leadership.'",'.$this->db->escape($input_data['leadership_comment']).',"'.$work_knowledge.'",'.$this->db->escape($input_data['work_knowledge_comment']).',"'.$decision_making.'",'.$this->db->escape($input_data['decision_making_comment']).',"'.$communication.'",'.$this->db->escape($input_data['communication_comment']).',"'.$crisis.'",'.$this->db->escape($input_data['crisis_comment']).','.$this->db->escape($input_data['overall']).','.$this->db->escape($input_data['other_comments']).',"'.$input_data['added_by'].'","'.$input_data['added_for'].'",'.$this->db->escape($input_data['leadership']).','.$this->db->escape($input_data['work_knowledge']).','.$this->db->escape($input_data['decision_making']).','.$this->db->escape($input_data['communication']).','.$this->db->escape($input_data['crisis']).','.$this->db->escape($input_data['overall_performance']).')');
        if ($query)
        {
            $response['stat'] = true;
            $response['message'] = 'Feedback Complete';
        } else
        {
            $response['stat'] = false;
            $response['message'] = 'Unable to Store Feedback';
        }
		
		echo json_encode($response);
    }
	
	
	public function feedback_details()
	{
		$fid = $this->input->get('fid');
		
		$sqldata = 'SELECT efp_performance.*,
				department.description as department_name,
				CONCAT(signin.fname," ",signin.lname) AS added_for_name,
				CONCAT(added_by.fname," ",added_by.lname) AS added_by_name
				FROM efp_performance
				LEFT JOIN signin ON signin.id = efp_performance.added_for
                LEFT JOIN signin AS added_by ON added_by.id = efp_performance.added_by
                LEFT JOIN department ON department.id = added_by.dept_id
				WHERE efp_performance.performance_id = "'.$fid.'"';
		$data['performancedata'] = $this->Common_model->get_query_row_array($sqldata);
		
		$data['assigned_to_name'] = $data['performancedata']['added_for_name'];
		$data['assigned_by_name'] = $data['performancedata']['added_by_name'];
		$data['department_name'] = $data['performancedata']['department_name'];
		
		$data['leadership'] = explode(',',$data['performancedata']['leadership_scores']);
		$data['work_knowledge'] = explode(',',$data['performancedata']['work_knowledge_scores']);
		$data['decision_making'] = explode(',',$data['performancedata']['decision_making_scores']);
		$data['communication'] = explode(',',$data['performancedata']['communication_scores']);
		$data['crisis'] = explode(',',$data['performancedata']['crisis_scores']);
		
		$this->load->view('employee_feedback/feedbackdetails',$data);
	}
	
	
	
	private function get_feedback_status($employee_id)
    {
		$qSql='SELECT COUNT(*) AS feedback_stat FROM efp_performance WHERE added_by="'.$employee_id.'" AND year_quarter="'.date('Y').'-'.$this->getQuarter(date('F')).'"';
		
		//echo $qSql;
		
        $query = $this->db->query($qSql);
		
        $row = $query->row();
        return $row->feedback_stat;
    }
	
	public function getQuarter($quarter){
		switch($quarter) {
			case 'January': return 1;
			case 'February': return 1;
			case 'March': return 1;

			case 'April': return 2;
			case 'May': return 2;
			case 'June': return 2;

			case 'July': return 3;
			case 'August': return 3;
			case 'September': return 3;

			case 'October': return 4;
			case 'November': return 4;
			case 'December': return 4;
		}
	}
	
	public function rowreport()
	{
		$data['assigned_to_id'] = get_assigned_to();
		
		$data['useroffice'] = $user_office_id = get_user_office_id();
		
		if(get_global_access()){
			$sqllocation = "SELECT * from office_location WHERE is_active = '1'";
		} else {
			$sqllocation = "SELECT * from office_location WHERE abbr = '$user_office_id'";
		}
		$data['location_list'] = $this->Common_model->get_query_result_array($sqllocation);
		
		$data['cquarter'] = $current_quarter = date('Y').'-'.$this->getQuarter(date('F'));
		$sqlquarter = "SELECT distinct(year_quarter) as yearlist from efp_performance ORDER by year_quarter";
		$data['quarter_list'] = $this->Common_model->get_query_result_array($sqlquarter);
		
		$data["content_template"] = "employee_feedback/raw_report.php";
		$data["aside_template"] = "employee_feedback/aside.php";
		$this->load->view('dashboard',$data);
	}
	
	
	public function get_quarter_year_distinct()
	{
		$loc = $this->input->get('oid');
		$sqlquarter  = "SELECT distinct(year_quarter) as yearlist from efp_performance WHERE location_id = '$loc' ORDER by year_quarter DESC";
		$quarterlist = $this->Common_model->get_query_result_array($sqlquarter);
		$count = 0;
		foreach($quarterlist as $tlist)
		{
			$count++;
			echo "<option value='".$tlist['yearlist']."'>".$tlist['yearlist']."</option>";
		}
		if($count == "0")
		{
			echo "<option value=''>-- No Reports Available --</option>";
		}
	}
	
	
	public function gen_rawreport() {

			$office_selected = $this->input->post('office_id');
			$quarter_selected = $this->input->post('quartertime');
			$reporttype = 'all_users';
			
			if($reporttype == "only_submitted"){
				
            $query = $this->db->query('SELECT department.description as department_name,efp_performance.added_for AS added_for_id,CONCAT(signin.fname," ",signin.lname) AS added_for,signin.fusion_id,efp_performance.location_id,efp_performance.year_quarter, efp_performance.added_by AS added_by_id,CONCAT(added_by.fname," ",added_by.lname) AS added_by,(SELECT GROUP_CONCAT(efp_questions.question SEPARATOR ",") FROM efp_questions  WHERE efp_questions.question_category_id = "1") AS leadership_questions,efp_performance.leadership_scores,efp_performance.leadership_comment,efp_performance.leadership_performance,
            (SELECT GROUP_CONCAT(efp_questions.question SEPARATOR ",") FROM efp_questions  WHERE efp_questions.question_category_id = "2") AS work_knowledge_questions,
            efp_performance.work_knowledge_scores,efp_performance.work_knowledge_comment,efp_performance.work_knowledge_performance,
            (SELECT GROUP_CONCAT(efp_questions.question SEPARATOR ",") FROM efp_questions  WHERE efp_questions.question_category_id = "3") AS decision_making_questions,
            efp_performance.decision_making_scores,efp_performance.decision_making_comment,efp_performance.decision_making_performance,
            (SELECT GROUP_CONCAT(efp_questions.question SEPARATOR ",") FROM efp_questions  WHERE efp_questions.question_category_id = "4") AS communication_questions,
            efp_performance.communication_scores,efp_performance.communication_comment,efp_performance.communication_performance,
            (SELECT GROUP_CONCAT(efp_questions.question SEPARATOR ",") FROM efp_questions  WHERE efp_questions.question_category_id = "5") AS crisis_questions
            ,efp_performance.crisis_scores,efp_performance.crisis_comment,efp_performance.crisis_performance,efp_performance.overall_performance AS total_score,efp_performance.overall,efp_performance.other_comments FROM `efp_performance`
            LEFT JOIN signin ON signin.id=efp_performance.added_for
            LEFT JOIN signin AS added_by ON added_by.id=efp_performance.added_by
            LEFT JOIN department ON department.id=added_by.dept_id
            WHERE  efp_performance.year_quarter="'.$quarter_selected.'" AND efp_performance.location_id = "'.$office_selected .'"
            ORDER BY department.id,efp_performance.added_for');
			
			}
			
			if($reporttype == "all_users"){

			$query = $this->db->query('
			SELECT "'.$quarter_selected.'" as quarter_selected, d.description as department_name, s.fusion_id, s.id as added_by_id, CONCAT(s.fname," ",s.lname) AS added_by, s.office_id, CONCAT(ad.fname," ",ad.lname) as added_for, ad.id as added_for_id, s.status,
			efp_performance.location_id,efp_performance.year_quarter, efp_performance.added_by AS added_by_id,(SELECT GROUP_CONCAT(efp_questions.question SEPARATOR ",") FROM efp_questions  WHERE efp_questions.question_category_id = "1") AS leadership_questions,efp_performance.leadership_scores,efp_performance.leadership_comment,efp_performance.leadership_performance,
            (SELECT GROUP_CONCAT(efp_questions.question SEPARATOR ",") FROM efp_questions  WHERE efp_questions.question_category_id = "2") AS work_knowledge_questions,
            efp_performance.work_knowledge_scores,efp_performance.work_knowledge_comment,efp_performance.work_knowledge_performance,
            (SELECT GROUP_CONCAT(efp_questions.question SEPARATOR ",") FROM efp_questions  WHERE efp_questions.question_category_id = "3") AS decision_making_questions,
            efp_performance.decision_making_scores,efp_performance.decision_making_comment,efp_performance.decision_making_performance,
            (SELECT GROUP_CONCAT(efp_questions.question SEPARATOR ",") FROM efp_questions  WHERE efp_questions.question_category_id = "4") AS communication_questions,
            efp_performance.communication_scores,efp_performance.communication_comment,efp_performance.communication_performance,
            (SELECT GROUP_CONCAT(efp_questions.question SEPARATOR ",") FROM efp_questions  WHERE efp_questions.question_category_id = "5") AS crisis_questions
            ,efp_performance.crisis_scores,efp_performance.crisis_comment,efp_performance.crisis_performance,efp_performance.overall_performance AS total_score,efp_performance.overall,efp_performance.other_comments,
			(SELECT GROUP_CONCAT((SELECT shname from client c where c.id=i.client_id)) FROM info_assign_client as i WHERE i.user_id = s.id) as client_name,
			(SELECT GROUP_CONCAT((SELECT name from process p where p.id=j.process_id)) FROM info_assign_process as j WHERE j.user_id = s.id) as process_name
			FROM signin as s
			LEFT JOIN signin AS ad ON ad.id=s.assigned_to
			LEFT JOIN (SELECT * from efp_performance WHERE year_quarter="'.$quarter_selected.'" AND location_id = "'.$office_selected .'") as efp_performance ON efp_performance.added_by = s.id
            LEFT JOIN department as d ON d.id=s.dept_id
            WHERE s.office_id = "'.$office_selected.'" AND s.status IN (1,3,4)
            ORDER BY d.id,added_for');
						
			}
			
			if ($query) {
				$result_object = $query->result_object();
				$this->gen($result_object, $reporttype);
			}
    }
	
	private function gen($infos, $reporttype)
    {
        //echo '<pre>';
        //print_r($infos);
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');

        define('EOL', (PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

        date_default_timezone_set('Europe/London');
        require_once APPPATH . 'third_party/PHPExcel.php';

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->freezePane('A3');
        $rowCount = 3;

        $style = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )
        );
        $objPHPExcel->getActiveSheet()->getStyle("A1:AF1")->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle("A2:AF2")->applyFromArray($style);

        $objPHPExcel->getActiveSheet()->mergeCells('A1:e1');
        $objPHPExcel->getActiveSheet()->getStyle("A1:AF1")->getFont()->setBold( true );
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'All Performance Report – EFP');

        $objPHPExcel->getActiveSheet()->getStyle("A2:AF2")->getFont()->setBold( true );
		$objPHPExcel->getActiveSheet()->getStyle("A2:AF2")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('CCCCCC');
		
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
        $objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Quarter Year');
				
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->SetCellValue('B2', 'Office Location');
		
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
        $objPHPExcel->getActiveSheet()->SetCellValue('C2', 'Department Name');
		
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
        $objPHPExcel->getActiveSheet()->SetCellValue('D2', 'Client Name');
		
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(40);
        $objPHPExcel->getActiveSheet()->SetCellValue('E2', 'Process Name');

		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
        $objPHPExcel->getActiveSheet()->SetCellValue('F2', 'Fusion ID');
		
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
        $objPHPExcel->getActiveSheet()->SetCellValue('G2', 'Employee Name');
		
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
        $objPHPExcel->getActiveSheet()->SetCellValue('H2', 'L1 Supervisor');

        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(70);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(70);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(30);
        $objPHPExcel->getActiveSheet()->SetCellValue('I2', 'Leadership Questions');
        $objPHPExcel->getActiveSheet()->SetCellValue('J2', 'Leadership Scores');
        $objPHPExcel->getActiveSheet()->SetCellValue('K2', 'Leadership Comment');
        $objPHPExcel->getActiveSheet()->SetCellValue('L2', 'Leadership Performance');

        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(70);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(70);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(30);
        $objPHPExcel->getActiveSheet()->SetCellValue('M2', 'Work Knowledge Questions');
        $objPHPExcel->getActiveSheet()->SetCellValue('N2', 'Work Knowledge Scores');
        $objPHPExcel->getActiveSheet()->SetCellValue('O2', 'Work Knowledge Comment');
        $objPHPExcel->getActiveSheet()->SetCellValue('P2', 'Work Knowledge Performance');

        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(70);
        $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(70);
        $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(30);
        $objPHPExcel->getActiveSheet()->SetCellValue('Q2', 'Decision Making Questions');
        $objPHPExcel->getActiveSheet()->SetCellValue('R2', 'Decision Making Scores');
        $objPHPExcel->getActiveSheet()->SetCellValue('S2', 'Decision Making Comment');
        $objPHPExcel->getActiveSheet()->SetCellValue('T2', 'Decision Making Performance');

        $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(70);
        $objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(70);
        $objPHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth(30);
        $objPHPExcel->getActiveSheet()->SetCellValue('U2', 'Communication Questions');
        $objPHPExcel->getActiveSheet()->SetCellValue('V2', 'Communication Scores');
        $objPHPExcel->getActiveSheet()->SetCellValue('W2', 'Communication Comment');
        $objPHPExcel->getActiveSheet()->SetCellValue('X2', 'Communication Performance');

        $objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setWidth(70);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setWidth(70);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AB')->setWidth(30);
        $objPHPExcel->getActiveSheet()->SetCellValue('Y2', 'Crisis Questions');
        $objPHPExcel->getActiveSheet()->SetCellValue('Z2', 'Crisis Scores');
        $objPHPExcel->getActiveSheet()->SetCellValue('AA2', 'Crisis Comment');
        $objPHPExcel->getActiveSheet()->SetCellValue('AB2', 'Crisis Performance');

        $objPHPExcel->getActiveSheet()->getColumnDimension('AC')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AD')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AE')->setWidth(70);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AF')->setWidth(20);
        $objPHPExcel->getActiveSheet()->SetCellValue('AC2', 'Total Score');
        $objPHPExcel->getActiveSheet()->SetCellValue('AD2', 'Overall');
        $objPHPExcel->getActiveSheet()->SetCellValue('AE2', 'Other Comments');
        $objPHPExcel->getActiveSheet()->SetCellValue('AF2', 'User Status');
		
        foreach($infos as $key=>$info)
        {
            $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':'.'AC'.$rowCount)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

            $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':'.'AC'.$rowCount)->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $info->quarter_selected);
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $info->office_id);
            $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $info->department_name);
            $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $info->client_name);
            $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $info->process_name);
			
			$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $info->fusion_id);
            $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $info->added_by);
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $info->added_for);
			
			if($info->location_id != ""){
			
			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $info->year_quarter);
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $info->location_id);
            $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, "*******");
			$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, "*******");
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $info->added_for);

            $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $info->leadership_questions);
            $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $info->leadership_scores);
            $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $info->leadership_comment);
            $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $info->leadership_performance);

            $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $info->work_knowledge_questions);
            $objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $info->work_knowledge_scores);
            $objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, $info->work_knowledge_comment);
            $objPHPExcel->getActiveSheet()->SetCellValue('P'.$rowCount, $info->work_knowledge_performance);

            $objPHPExcel->getActiveSheet()->SetCellValue('Q'.$rowCount, $info->decision_making_questions);
            $objPHPExcel->getActiveSheet()->SetCellValue('R'.$rowCount, $info->decision_making_scores);
            $objPHPExcel->getActiveSheet()->SetCellValue('S'.$rowCount, $info->decision_making_comment);
            $objPHPExcel->getActiveSheet()->SetCellValue('T'.$rowCount, $info->decision_making_performance);

            $objPHPExcel->getActiveSheet()->SetCellValue('U'.$rowCount, $info->communication_questions);
            $objPHPExcel->getActiveSheet()->SetCellValue('V'.$rowCount, $info->communication_scores);
            $objPHPExcel->getActiveSheet()->SetCellValue('W'.$rowCount, $info->communication_comment);
            $objPHPExcel->getActiveSheet()->SetCellValue('X'.$rowCount, $info->communication_performance);

            $objPHPExcel->getActiveSheet()->SetCellValue('Y'.$rowCount, $info->crisis_questions);
            $objPHPExcel->getActiveSheet()->SetCellValue('Z'.$rowCount, $info->crisis_scores);
            $objPHPExcel->getActiveSheet()->SetCellValue('AA'.$rowCount, $info->crisis_comment);
            $objPHPExcel->getActiveSheet()->SetCellValue('AB'.$rowCount, $info->crisis_performance);

            $objPHPExcel->getActiveSheet()->SetCellValue('AC'.$rowCount, $info->total_score);
            $objPHPExcel->getActiveSheet()->SetCellValue('AD'.$rowCount, $info->overall);
            $objPHPExcel->getActiveSheet()->SetCellValue('AE'.$rowCount, $info->other_comments);
						
			}
			
			if($info->status == 1){
            $objPHPExcel->getActiveSheet()->SetCellValue('AF'.$rowCount, "Active");
			}
			if($info->status == 3){
            $objPHPExcel->getActiveSheet()->SetCellValue('AF'.$rowCount, "Suspended");
			}
			if($info->status == 4){
            $objPHPExcel->getActiveSheet()->SetCellValue('AF'.$rowCount, "New");
			}
			
			
            $rowCount++;
        }
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="employee_feedback_report.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->setIncludeCharts(TRUE);

        $objWriter->save('php://output');
    }
}