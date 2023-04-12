<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
* ==========================
* Created By: SOURAV SARKAR
* Created On: 13-12-2022
* ==========================
**/

class Qa_boomsourcing_vertical_campaign extends CI_Controller {

	function __construct() {

		parent::__construct();
		$this->load->model('Common_model');
	}

	public function index(){

		if(check_logged_in()){

			$data["aside_template"]   = "qa_boomsourcing_aside/aside.php";
			$data["content_template"] = "qa_boomsourcing/manage_vertical_campaign.php";
			$data["content_js"] = "qa_boomsourcing/manage_vertical_campaign_js.php";

			$this->load->view('dashboard',$data);
		}
	}

	public function add_new_vertical(){

		if(check_logged_in()){


			try {
					$this->db->trans_begin();

					$vertical = $this->input->post('verticalName');

				    
				    if(!$this->db->insert('boomsourcing_vertical',array('vertical'=>$vertical))){
						throw new Exception('Something went wrong on inserting data on boomsourcing_vertical at line number: '.__LINE__,500);
					}

					$this->db->trans_commit();

					echo json_encode(array('success'=>true,'msg'=>"New vertical added successfully."));

				} catch (Exception $e) {
				
				/*if something error occur then rollback the database (previous state)*/
				$this->db->trans_rollback();

				// echo "Error: " . $e->getMessage();
				echo json_encode(array('success'=>false,'msg'=>"Something went wrong."));
			}
			
		}
	}

	public function get_vertical_by_id(){

		if(check_logged_in()){

			$verticalId = $this->input->post('verticalId');

			$sql = "SELECT * FROM `boomsourcing_vertical` bv WHERE bv.id = $verticalId";
			$result = $this->db->query($sql)->row_array();

			echo json_encode(array('success'=>true,'verticalId'=>$result['id'],'verticalName'=>$result['vertical']));
		}
	}

	public function update_vertical(){

		if(check_logged_in()){

			$verticalId = $this->input->post('verticalEditId');
			$vertical = $this->input->post('verticalName');

			try {
					$this->db->trans_begin();

					$vertical = $this->input->post('verticalName');

				    
				    if(!$this->db->update('boomsourcing_vertical', array('vertical'=>$vertical), array('id' => $verticalId))){
						throw new Exception('Something went wrong on updating data on boomsourcing_vertical at line number: '.__LINE__,500);
					}

					$this->db->trans_commit();

					echo json_encode(array('success'=>true,'msg'=>"Vertical updated successfully."));

				} catch (Exception $e) {
				
				/*if something error occur then rollback the database (previous state)*/
				$this->db->trans_rollback();

				// echo "Error: " . $e->getMessage();
				echo json_encode(array('success'=>false,'msg'=>"Something went wrong."));
			}
		}
	}

	public function get_vertical_list(){

		if(check_logged_in()){

			$sql = "SELECT * FROM `boomsourcing_vertical` dv";
			$result = $this->db->query($sql)->result_array();

			echo json_encode(array('success'=>true,'data'=>$result));
		}
	}

	public function change_vertical_active_in_active_status()
	{
		if(check_logged_in()){

			$this->db->trans_begin();

			try{

				$verticalId = $this->input->post('verticalId');
				$status = $this->input->post('status');

				$sql = "UPDATE `boomsourcing_vertical` SET `is_active` = $status WHERE `id` = $verticalId";

				if(!$this->db->query($sql)){
					throw new Exception('Something went wrong on updating boomsourcing_vertical is_active status',500);
				}

				$this->db->trans_commit();

				echo json_encode(array('success'=>true,'msg'=>"Status updated successfully!"));

			} catch (Exception $e) {
				
				/*if something error occur then rollback the database (previous state)*/
				$this->db->trans_rollback();

				// echo "Error: " . $e->getMessage();
				echo json_encode(array('success'=>false,'msg'=>'Something went wrong!','error'=>$e->getMessage()));
			}
		}
	}

	/*For Campaign*/

	public function get_campaign_list(){

		if(check_logged_in()){

			$sql = "SELECT * FROM `boomsourcing_campaign`";
			$result = $this->db->query($sql)->result_array();

			echo json_encode(array('success'=>true,'data'=>$result));
		}
	}

	public function get_campaign_by_id(){

		if(check_logged_in()){

			$campaignId = $this->input->post('campaignId');

			$sql = "SELECT * FROM `boomsourcing_campaign` bc WHERE bc.id = $campaignId";
			$result = $this->db->query($sql)->row_array();

			echo json_encode(array('success'=>true,'campaignId'=>$result['id'],'campaignName'=>$result['campaign']));
		}
	}

	public function add_new_campaign(){

		if(check_logged_in()){


			try {
					$this->db->trans_begin();

					$campaign = $this->input->post('campaignName');

				    
				    if(!$this->db->insert('boomsourcing_campaign',array('campaign'=>$campaign))){
						throw new Exception('Something went wrong on inserting data on boomsourcing_campaign at line number: '.__LINE__,500);
					}

					$this->db->trans_commit();

					echo json_encode(array('success'=>true,'msg'=>"New campaign added successfully."));

				} catch (Exception $e) {
				
				/*if something error occur then rollback the database (previous state)*/
				$this->db->trans_rollback();

				// echo "Error: " . $e->getMessage();
				echo json_encode(array('success'=>false,'msg'=>"Something went wrong."));
			}
			
		}
	}

	public function update_campaign(){

		if(check_logged_in()){

			try {
					$this->db->trans_begin();

					$campaignId = $this->input->post('campaignEditId');
					$campaign = $this->input->post('campaignName');

				    
				    if(!$this->db->update('boomsourcing_campaign', array('campaign'=>$campaign), array('id' => $campaignId))){
						throw new Exception('Something went wrong on updating data on boomsourcing_campaign at line number: '.__LINE__,500);
					}

					$this->db->trans_commit();

					echo json_encode(array('success'=>true,'msg'=>"Campaign updated successfully."));

				} catch (Exception $e) {
				
				/*if something error occur then rollback the database (previous state)*/
				$this->db->trans_rollback();

				// echo "Error: " . $e->getMessage();
				echo json_encode(array('success'=>false,'msg'=>"Something went wrong."));
			}
		}
	}

	public function change_campaign_active_in_active_status()
	{
		if(check_logged_in()){

			$this->db->trans_begin();

			try{

				$campaignId = $this->input->post('campaignId');
				$status = $this->input->post('status');

				$sql = "UPDATE `boomsourcing_campaign` SET `is_active` = $status WHERE `id` = $campaignId";

				if(!$this->db->query($sql)){
					throw new Exception('Something went wrong on updating boomsourcing_campaign is_active status',500);
				}

				$this->db->trans_commit();

				echo json_encode(array('success'=>true,'msg'=>"Status updated successfully!"));

			} catch (Exception $e) {
				
				/*if something error occur then rollback the database (previous state)*/
				$this->db->trans_rollback();

				// echo "Error: " . $e->getMessage();
				echo json_encode(array('success'=>false,'msg'=>'Something went wrong!','error'=>$e->getMessage()));
			}
		}
	}
}