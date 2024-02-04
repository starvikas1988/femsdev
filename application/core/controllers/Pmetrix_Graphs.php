<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pmetrix_Graphs extends CI_Controller {
    
	 function __construct() {
		parent::__construct();

		$this->load->model('Common_model');
		$this->load->model('user_model');
		$this->load->model('Pmetrix_Graphs_Model');
	 }
	 
	  public function index() {

		  if(check_logged_in()){
			
			if(get_login_type() == "client") redirect(base_url().'pmetrix_v2_client',"refresh");
			
			//FKOL002152//FKOL002543
			$current_user = get_user_id();
			$data['oValue'] = get_user_office_id();
			$data['cValue'] = get_client_ids();
			$data['pValue'] = get_process_ids();
			$data['rValue'] = get_role_dir();
			
			
			$data["aside_template"] = "pmetrix_v2_management/aside.php";
			if(get_role_dir()=="super" || get_global_access()==1){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			$data['client_list'] =array();
			$data['process_list'] =array();
			$process_ids = get_process_ids();
			
			$post_period_query = $this->db->query('SELECT DISTINCT kpi_value FROM `pm_data_v2` WHERE kpi_id=588 ORDER BY kpi_value ASC');
			if($post_period_query)
			{
				$data['post_period'] = $post_period_query->result_object();
			}
			
			//bar chart start here
			$get_assigned = $this->Pmetrix_Graphs_Model->get_assigned_val();
			$get_resolved = $this->Pmetrix_Graphs_Model->get_resolved_val();
			
			$dataSet = [];
			$label_array = ["","","","","","","","","","","",""];
			$assigned_array = ["","","","","","","","","","","",""];
			$resolved_array = ["","","","","","","","","","","",""];
  
			for($i=0; $i<count($get_assigned); $i++){
			  for($j=0; $j<count($get_resolved); $j++){
				  if($get_resolved[$j]["DATE_FORMAT(start_date, '%M')"] === $get_assigned[$i]["DATE_FORMAT(start_date, '%M')"]){
					  $month = $get_assigned[$i]["MONTH(start_date)"];
					  $month_name = $get_assigned[$i]["DATE_FORMAT(start_date, '%M')"];
					  $assigned_count = $get_assigned[$i]["assigned_count_sum"];
					  $resolved_count = $get_resolved[$j]["resolved_count_sum"];
  
					  $label_array[$month] = number_format((($resolved_count/$assigned_count) * 100) ,2);
					  $assigned_array[$month] = $assigned_count;
					  $resolved_array[$month] = $resolved_count;
				  }
			  }
			}
  
			$dataSet[] = array(
				"label"=> "Assigned Count",
				"yAxisID" => "A",
				"backgroundColor"=> 'rgba(0, 0, 0, 0.2)',
				"borderWidth"=> 1,
				"barThickness"=> 50,
				"data"=> $assigned_array,
				"xAxisID"=> "bar-x-axis1",
			);
			$dataSet[] = array(
				"label"=> "Resolved Count",
				"yAxisID" => "A",
				"backgroundColor"=> 'rgba(0, 0, 255, 0.5)',
				"borderWidth"=> 1,
				"barThickness"=> 25,
				"data"=> $resolved_array,
				"xAxisID"=> "bar-x-axis2",
			);
			$dataSet[] = array(
				"label"=> "Resolved %",
				"yAxisID" => "B",
				"type"=> "line",
				"fill"=> "false",
				"backgroundColor"=> '#0000cc',
				"borderColor"=> '#0000cc',
				"borderWidth"=> 3,
				"data"=> $label_array,
				"xAxisID"=> "bar-x-axis3"
			);

			$label = ["Jan", "Feb", "Mar", "Apr", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
			$data['label'] = json_encode($label);
			$data['dataSet'] = json_encode($dataSet);

			//bar chart ends here

			//line chart start here

			$get_active_time_target = $this->Pmetrix_Graphs_Model->get_active_time_target();
			$get_avg_active_time = $this->Pmetrix_Graphs_Model->get_avg_active_time();

			$active_time_target = ["","","","","","","","","","","",""];
			$avg_active_time = ["","","","","","","","","","","",""];

			for($i=0; $i<count($get_active_time_target); $i++){
			  for($j=0; $j<count($get_avg_active_time); $j++){
				  if($get_avg_active_time[$j]["DATE_FORMAT(start_date, '%M')"] === $get_active_time_target[$i]["DATE_FORMAT(start_date, '%M')"]){
					  //$line_month = $get_active_time_target[$i]["MONTH(start_date)"];
					  //$line_month_name = $get_active_time_target[$i]["DATE_FORMAT(start_date, '%M')"];
					  $active_time_target[$month] = $get_active_time_target[$i]["Active_Time_Target"];
					  $avg_active_time[$month] = $get_avg_active_time[$j]["Avg_Active_Time"];
				  }
			  }
			}
			$line_dataset = [];
			$line_dataset[] = array(
				"label"=> "Target",
				"backgroundColor"=> 'blue',
				"borderColor"=> 'blue',
				"data"=> $active_time_target,
				"fill"=> false
			);
			$line_dataset[] = array(
				"label"=> "Average Active Time",
				"backgroundColor"=> 'orange',
				"borderColor"=> 'orange',
				"data"=> $avg_active_time,
				"fill"=> false
			);
			
			$data["line_dataset"] = json_encode($line_dataset);
			//line chart ends here

			$data["content_js"] = "pmetrix_v2/graph.php";
		    $data["content_template"] = "pmetrix_v2/Pmetrix_Graphs_view.php";
		  
	        $this->load->view('dashboard',$data);
		}

	  }

	  public function get_dynamic_graph(){
		  $form_data = $this->input->post();
		  $get_assigned = $this->Pmetrix_Graphs_Model->get_assigned_val($form_data);
		  $get_resolved = $this->Pmetrix_Graphs_Model->get_resolved_val($form_data);
		  
	      $dataSet = [];
		  $label_array = ["","","","","","","","","","","",""];

		  for($i=0; $i<count($get_assigned); $i++){
		    for($j=0; $j<count($get_resolved); $j++){
				if($get_resolved[$j]["DATE_FORMAT(start_date, '%M')"] === $get_assigned[$i]["DATE_FORMAT(start_date, '%M')"]){
					$month = $get_assigned[$i]["MONTH(start_date)"];
					$month_name = $get_assigned[$i]["DATE_FORMAT(start_date, '%M')"];
					$assigned_count = $get_assigned[$i]["assigned_count_sum"];
					$resolved_count = $get_resolved[$j]["resolved_count_sum"];

					$label_array[$month] = number_format((($resolved_count/$assigned_count) * 100) ,2);
				}
		    }
		  }

	      $dataSet[] = array(
						  "label" => "Resolved (%)",
						  "backgroundColor" => "#0099cc",
						  "borderColor" => "#0000cc",
						  "borderWidth" => "1",
						  "data" => $label_array
					  );

		 
		  $label = ["Jan", "Feb", "Mar", "Apr", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
		  echo json_encode(array('label' => $label, 'dataSet' => $dataSet));
	  }
}
?>