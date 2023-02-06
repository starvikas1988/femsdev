<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Email_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	public function new_ijp($location, $requisition_id)
	{
		$requisition_query = $this->db->query('SELECT ijp_requisitions.*,role_organization.rank FROM ijp_requisitions
			LEFT JOIN role_organization
				ON role_organization.id=ijp_requisitions.new_designation_id
			WHERE requisition_id="' . $requisition_id . '"');
		$requisition_result = $requisition_query->result_object();
		if ($requisition_result[0]->ffunction == "Support") {
			if ($requisition_result[0]->movement_type == "V") {
				$rank = ' AND FLOOR(role_organization.rank) = "' . (floor($requisition_result[0]->rank) + 1) . '"';
			} else if ($requisition_result[0]->movement_type == "L") {
				$rank = ' AND FLOOR(role_organization.rank) = "' . floor($requisition_result[0]->rank) . '"';
			} else if ($requisition_result[0]->movement_type == "B") {
				$rank = ' AND FLOOR(role_organization.rank) <= "' . (floor($requisition_result[0]->rank) + 1) . '"  AND FLOOR(role_organization.rank) >= "' . floor($requisition_result[0]->rank) . '"';
			}

			if ($requisition_result[0]->posting_type == "I") {
				$user_query = 'SELECT signin.email_id,signin.fname,signin.lname FROM signin
				
				LEFT JOIN role_organization
					ON role_organization.id=signin.org_role_id
				
				WHERE signin.dept_id="' . $requisition_result[0]->dept_id . '" AND signin.sub_dept_id="' . $requisition_result[0]->sub_debt_id . '" AND signin.office_id="' . $requisition_result[0]->location_id . '" AND TIMESTAMPDIFF(MONTH, signin.doj, CURDATE()) > ' . $requisition_result[0]->set_tenurity . ' ' . $rank . ' ';
			} else if ($requisition_result->posting_type == "E") {
				$user_query = 'SELECT signin.email_id,signin.fname,signin.lname FROM signin
				
				LEFT JOIN role_organization
					ON role_organization.id=signin.org_role_id
				
				WHERE  signin.office_id ="' . $requisition_result[0]->location_id . '" AND TIMESTAMPDIFF(MONTH, signin.doj, CURDATE()) > ' . $requisition_result[0]->set_tenurity . ' ' . $rank . ' ';
			}
		} else if ($requisition_result[0]->ffunction == "Operation") {
			if ($requisition_result[0]->movement_type == "V") {
				$rank = ' AND FLOOR(role_organization.rank) = "' . (floor($requisition_result[0]->rank) + 1) . '"';
			} else if ($requisition_result[0]->movement_type == "L") {
				$rank = ' AND FLOOR(role_organization.rank) = "' . floor($requisition_result[0]->rank) . '"';
			} else if ($requisition_result[0]->movement_type == "B") {
				$rank = ' AND FLOOR(role_organization.rank) <= "' . (floor($requisition_result[0]->rank) + 1) . '"  AND FLOOR(role_organization.rank) >= "' . floor($requisition_result[0]->rank) . '"';
			}

			if ($requisition_result[0]->posting_type == "I") {
				$user_query = 'SELECT signin.email_id,signin.fname,signin.lname FROM signin
				
				LEFT JOIN role_organization
					ON role_organization.id=signin.org_role_id
				LEFT JOIN info_assign_client
					ON info_assign_client.user_id=signin.id
				LEFT JOIN info_assign_process
					ON info_assign_process.user_id=signin.id
				
				WHERE info_assign_client.client_id="' . $requisition_result[0]->client_id . '" AND FIND_IN_SET(info_assign_process.process_id, "' . $requisition_result[0]->process_id . '") AND signin.office_id="' . $requisition_result[0]->location_id . '" AND TIMESTAMPDIFF(MONTH, signin.doj, CURDATE()) > ' . $requisition_result[0]->set_tenurity . ' ' . $rank . ' ';
			} else if ($requisition_result[0]->posting_type == "E") {
				$user_query = 'SELECT signin.email_id,signin.fname,signin.lname FROM signin
				
				LEFT JOIN role_organization
					ON role_organization.id=signin.org_role_id
				LEFT JOIN info_assign_client
					ON info_assign_client.user_id=signin.id
				LEFT JOIN info_assign_process
					ON info_assign_process.user_id=signin.id
				
				WHERE  signin.office_id ="' . $requisition_result[0]->location_id . '" AND TIMESTAMPDIFF(MONTH, signin.doj, CURDATE()) > ' . $requisition_result[0]->set_tenurity . ' ' . $rank . ' ';
			}
		}
		
		//echo $user_query;

		/* $query = $this->db->query('SELECT * FROM `notification_info` WHERE office_id="'.$location.'" AND sch_for="NEW_IJP"');
		$row = $query->row();
		return $this->send_email_sox($current_user, $eto, $row->cc_email_id, $ebody, ''.$row->email_subject ,"" ,$row->from_email,$row->from_name,"Y"); */
		
	}




	public function resend_employee_offer_letter($c_id, $offer_letter, $doc_link = "")
	{

		$uid = get_user_id();
		//$eto = 'saikat.ray@omindtech.com,sankha.chowdhury@omindtech.com,sakil.khan@omindtech.com';
		$eto = '';
		$ecc = array();
		$nbody = "";


		$qSql = "select fusion_id, fname, lname, brand, concat(fname, ' ', lname) as c_name, doj, role_id, office_id, email_id_off, email_id_per, (select name from role r where r.id=s.role_id) as role_name ,s.site_id,mc.name as company_name
		from signin s 
		LEFT JOIN info_personal iper on iper.user_id=s.id 
		LEFT JOIN master_company mc on mc.id=s.brand 
		Where s.id=$c_id limit 1";

		$query = $this->db->query($qSql);
		$cRow = $query->row_array();
		$off_id = $cRow["office_id"];
		$site_id = $cRow['site_id'];
		$brand = $cRow['brand'];
		
		// $check_site_id = array('34','35');		
		// $cond = "";
		// if($brand == 3) $cond .=" and brand_id = 3";
		// if(in_array($site_id, $check_site_id)) $cond .=" and site_id = $site_id";

		// $qSql = "select * from notification_info where sch_for='DFR-Candidate Selected' and is_active=1 and office_id = $off_id $cond";
		// $query = $this->db->query($qSql);
		// if ($query->num_rows() > 0) {
		// 	$res = $query->row_array();
		$event = 'DFR-Candidate Selected';

		$res = get_notification_info($event,$brand,$site_id,$off_id);

		if (count($res) > 0) {
			// echo "<pre>"; print_r($res);
			$email_subject = $res["email_subject"] . ' - ' . $cRow["c_name"] . ' - ' . $cRow["fusion_id"];

			$eto= $cRow["email_id_per"]. ",". $res["email_id"];		
			
			$ecc[] = $res["email_id"];
			$ecc[] = $res["cc_email_id"];
			
			// $config_email = get_mail_config(	);

			$company_name = $cRow['company_name'];
			$company_hr = $res['signature_text'];

			$cc = array_filter($ecc);


			$from_email = $res["from_email"];
			$from_name = $res["from_name"];


			$nbody = '
					Dear <b>' . $cRow["c_name"] . '</b></br></br>
						Thank you for taking the time to talk to us about the <b>' . $cRow["role_name"] . '</b> position. It was a pleasure getting to meet you and we think that you would be a good fit for this role.		
						</br></br>
						
						I am pleased to extend the following offer of employment to you on behalf of ' . $company_name . '. You have been selected for the <b>' . $cRow["role_name"] . '</b> position. Congratulations!
						</br></br>
						
						We believe that your knowledge, skills and experience would be an ideal fit for our organization. We hope you will enjoy your role and make a significant contribution to the overall success of ' . $company_name . '.
						</br></br>
						
						Please take the time to review our offer. It includes important details about your compensation, benefits and the terms and conditions of your anticipated employment with ' . $company_name . '.
						</br></br>';

			if ($doc_link != "") {
				//

				$nbody .= "Please Upload Your Documents: <a href='" . $doc_link . "' target='_blank'>Click to Upload Your Documents</a></br></br>";
			}

			$nbody .= 'Looking forward to hearing back from you,

						</br>
						</br>
						</br>
						
					Regards, </br>
					'. $company_hr .'</br>

				';


			$this->send_email_sox($uid, $eto, implode(',', $cc), $nbody, $email_subject, $offer_letter, $from_email, $from_name,'Y',$brand);
	
		}
	}


	public function send_selection_email($location, $current_user, $eto, $user_id, $requisition_id, $hiring_manager_id)
	{
		// $query = $this->db->query('SELECT * FROM `notification_info` WHERE office_id="' . $location . '" AND sch_for="REQUISITION_SELECT_MAIL"');
		// $row = $query->row();
		
		
		//$get_user_info_query = $this->db->query('SELECT CONCAT(signin.fname," ",signin.lname) AS candidate_name,role_organization.name AS old_designation,CONCAT(old_l1.fname," ",old_l1.lname) AS old_l1,old_l1.email_id AS old_l1_email,l2.email_id AS old_l2_email,GROUP_CONCAT(CONCAT(new_l1.fname," ",new_l1.lname) SEPARATOR ", ") AS new_l1,GROUP_CONCAT(new_l1.email_id SEPARATOR ", ") AS new_l1_email,(SELECT role_organization.name FROM ijp_requisitions LEFT JOIN role_organization ON role_organization.id=ijp_requisitions.new_designation_id WHERE ijp_requisitions.requisition_id="'.$requisition_id.'") AS new_designation FROM `signin` LEFT JOIN role_organization ON role_organization.id=signin.org_role_id LEFT JOIN signin AS old_l1 ON old_l1.id=signin.assigned_to LEFT JOIN signin AS l2 ON l2.id=old_l1.assigned_to LEFT JOIN signin AS new_l1 ON FIND_IN_SET(new_l1.id,"'.$hiring_manager_id.'") WHERE signin.id = "'.$user_id.'" GROUP BY signin.id');

		$get_user_info_query = $this->db->query('SELECT signin.brand, CONCAT(signin.fname," ",signin.lname) AS candidate_name,role_organization.name AS old_designation,CONCAT(old_l1.fname," ",old_l1.lname) AS old_l1,info_personal.email_id_off AS old_l1_email,info_personal_l2.email_id_off AS old_l2_email,GROUP_CONCAT(CONCAT(new_l1.fname," ",new_l1.lname) SEPARATOR ", ") AS new_l1,GROUP_CONCAT(new_l1.email_id SEPARATOR ", ") AS new_l1_email,(SELECT role_organization.name FROM ijp_requisitions LEFT JOIN role_organization ON role_organization.id=ijp_requisitions.new_designation_id WHERE ijp_requisitions.requisition_id="' . $requisition_id . '") AS new_designation FROM `signin`
		LEFT JOIN role_organization ON role_organization.id=signin.org_role_id 
		LEFT JOIN signin AS old_l1 ON old_l1.id=signin.assigned_to LEFT JOIN info_personal AS info_personal ON info_personal.user_id=signin.assigned_to 
		LEFT JOIN info_personal AS info_personal_l2 ON info_personal_l2.user_id=old_l1.assigned_to 
		LEFT JOIN signin AS new_l1 ON FIND_IN_SET(new_l1.id,"' . $hiring_manager_id . '") 
		WHERE signin.id = "' . $user_id . '" GROUP BY signin.id');

	
		$row1 = $get_user_info_query->row();
		$candidate_name = $row1->candidate_name;
		$old_designation = $row1->old_designation;
		$old_l1 = $row1->old_l1;
		$old_l2_email = $row1->old_l2_email;
		$new_l1 = $row1->new_l1;
		$new_designation = $row1->new_designation;
		//$row->cc_email_id .= ','.$row1->old_l1_email.','.$row1->old_l2_email.','.$row1->new_l1_email;
		$eto = $eto;
				
		$brand = $row1->brand;
		$site_id = "";
		$event = 'REQUISITION_SELECT_MAIL';
		$row = get_notification_info($event,$brand,$site_id,$location);
		
		$cc_email_id = $row['cc_email_id'] . ',' . $row1->old_l1_email.','.$row1->old_l2_email.','.$row1->new_l1_email;

		$var_array = array('$candidate_name', '$old_designation', '$old_l1', '$new_l1', '$new_designation', '$requisition_id ');
		$rep_var_array = array($candidate_name, $old_designation, $old_l1, $new_l1, $new_designation, $requisition_id);
		$ebody = str_replace($var_array, $rep_var_array, $row['email_body']);
		
		return $this->send_email_sox($user_id, $eto, $cc_email_id , $ebody, '' . $row['email_subject'], "", $row['from_email'], $row['from_name'], "Y",$brand);
		
				
		
	}

	public function send_interview_schedule_email($location, $current_user, $user_id, $requisition_id, $hiring_manager_id)
	{
		// $query = $this->db->query('SELECT * FROM `notification_info` WHERE office_id="' . $location . '" AND sch_for="SCHEDULE_INTERVIEW"');
		// $row = $query->row();
		
		/* $get_user_info_query = $this->db->query('SELECT CONCAT(signin.fname," ",signin.lname) AS candidate_name,signin.email_id as c_email,DATE(ijp_interview_schedule.schedule_datetime) AS interview_date,DATE_FORMAT(ijp_interview_schedule.schedule_datetime,"%H:%i:%s") AS interview_time,ijp_requisitions.location_id AS interview_location,l1.email_id AS l1_email,l2.email_id AS l2_email, GROUP_CONCAT(hm.email_id SEPARATOR ",") AS hm_email FROM ijp_requisition_applications LEFT JOIN signin ON signin.id=ijp_requisition_applications.user_id
			LEFT JOIN ijp_interview_schedule ON CONCAT(ijp_interview_schedule.user_id,"",ijp_interview_schedule.requisition_id)=CONCAT(ijp_requisition_applications.user_id,"",ijp_requisition_applications.requisition_id)
			LEFT JOIN ijp_requisitions ON ijp_requisitions.requisition_id=ijp_requisition_applications.requisition_id
			LEFT JOIN signin AS l1 ON l1.id=signin.assigned_to
			LEFT JOIN signin AS l2 ON l2.id=l1.assigned_to
			LEFT JOIN signin AS hm ON FIND_IN_SET(hm.id,"'.$hiring_manager_id.'")
			WHERE signin.id = "'.$user_id.'" AND ijp_requisition_applications.status="ScheduleInterview" AND ijp_requisition_applications.requisition_id="'.$requisition_id.'"
			GROUP BY ijp_requisition_applications.user_id'); */

		$get_user_info_query = $this->db->query('SELECT CONCAT(signin.fname," ",signin.lname) AS candidate_name,signin.brand as brand,signin.email_id as c_email,DATE(ijp_interview_schedule.schedule_datetime) AS interview_date,DATE_FORMAT(ijp_interview_schedule.schedule_datetime,"%H:%i:%s") AS interview_time,ijp_requisitions.location_id AS interview_location,info_personal.email_id_off AS l1_email,l2.email_id_off AS l2_email, GROUP_CONCAT(hm.email_id_off SEPARATOR ",") AS hm_email FROM ijp_requisition_applications 
LEFT JOIN signin ON signin.id=ijp_requisition_applications.user_id
LEFT JOIN ijp_interview_schedule ON CONCAT(ijp_interview_schedule.user_id,"",ijp_interview_schedule.requisition_id)=CONCAT(ijp_requisition_applications.user_id,"",ijp_requisition_applications.requisition_id)
LEFT JOIN ijp_requisitions ON ijp_requisitions.requisition_id=ijp_requisition_applications.requisition_id
LEFT JOIN signin AS l1 ON l1.id=signin.assigned_to
LEFT JOIN info_personal AS info_personal ON info_personal.user_id=signin.assigned_to 
LEFT JOIN info_personal AS l2 ON l2.user_id=l1.assigned_to
LEFT JOIN info_personal AS hm ON FIND_IN_SET(hm.user_id,"' . $hiring_manager_id . '")
WHERE signin.id = "' . $user_id . '" AND ijp_requisition_applications.status="ScheduleInterview" AND ijp_requisition_applications.requisition_id="' . $requisition_id . '"
GROUP BY ijp_requisition_applications.user_id');




		$row1 = $get_user_info_query->row();
		$candidate_name = $row1->candidate_name;
		$interview_date = $row1->interview_date;
		$interview_time = $row1->interview_time;
		$interview_location = $row1->interview_location;
		$l1_email = $row1->l1_email;
		$l2_email = $row1->l2_email;
		$hm_email = $row1->hm_email;
		$brand = $row1->brand;

		$site_id = "";
		$event = 'SCHEDULE_INTERVIEW';
		$row = get_notification_info($event,$brand,$site_id,$location);
		
		//$row['cc_email_id'] = ""; //.= ','.$l1_email.','.$l2_email.','.$hm_email;
		$cc_email_id = $row['cc_email_id'] . ','. $l1_email.','.$l2_email.','.$hm_email;
		
		$eto = $row1->c_email;
		$var_array = array('$candidate_name', '$interview_date', '$interview_time', '$interview_location', '$requisition_id ');
		$rep_var_array = array($candidate_name, $interview_date, $interview_time, $interview_location, $requisition_id);
		$ebody = str_replace($var_array, $rep_var_array, $row['email_body']);


		return $this->send_email_sox($current_user, $eto, $cc_email_id, $ebody, '' . $row['email_subject'], "", $row['from_email'], $row['from_name'], "Y",$brand);
				
	}

	public function send_interview_panel_schedule_email($location, $current_user, $user_id, $requisition_id, $hiring_manager_id, $interview_schedulue_time)
	{
		// $query = $this->db->query('SELECT * FROM `notification_info` WHERE office_id="' . $location . '" AND sch_for="PANEL_INVITE"');
		// $row = $query->row();

		$brand = "";
		$site_id = "";
		$event = 'PANEL_INVITE';

		$row = get_notification_info($event,$brand,$site_id,$location);

		$q1 = $this->db->query('SELECT CONCAT(signin.fname," ",signin.lname) AS panel_interviewer_name,info_personal.email_id_off AS pan_email  FROM `signin`
LEFT JOIN info_personal ON info_personal.user_id=signin.id WHERE signin.id="' . $user_id . '" AND NOT FIND_IN_SET(signin.id,"' . $hiring_manager_id . '")');
		$q = $q1->row();

		if ($q1->num_rows() > 0) {
			$hir_manage_query = $this->db->query('SELECT CONCAT(signin.fname," ",signin.lname) AS hir_manager_name,info_personal.email_id_off AS hir_manager_email  FROM `signin`
	LEFT JOIN info_personal ON info_personal.user_id=signin.id WHERE  FIND_IN_SET(signin.id,"' . $hiring_manager_id . '")');
			$hir_manage_query_rows = $hir_manage_query->result_object();
			$h_manager_array = array();
			foreach ($hir_manage_query_rows as $key => $value) {
				$h_manager_array['hir_manager_name'][] = $value->hir_manager_name;
				$h_manager_array['hir_manager_email'][] = $value->hir_manager_email;
			}
			$hr_manager_name = implode(', ',$h_manager_array['hir_manager_name']);
			$hr_manager_email = implode(', ',$h_manager_array['hir_manager_email']);
			$panel_interviewer_name = $q->panel_interviewer_name;
			$ijp_code = $requisition_id;
			$interview_location = $location;
			$dt = new DateTime($interview_schedulue_time);

			$interview_date = $dt->format('Y-m-d');
			$interview_time = $dt->format('H:i:s');

			$var_array = array('$panel_interviewer_name', '$hr_manager_name', '$ijp_code', '$interview_date', '$interview_time', '$interview_location');
			$rep_var_array = array($panel_interviewer_name, $hr_manager_name, $ijp_code, $interview_date, $interview_time, $interview_location);
			$ebody = str_replace($var_array, $rep_var_array, $row['email_body']);
			$eto = $q->pan_email;
			return $this->send_email_sox($current_user, $eto, $hr_manager_email, $ebody, '' . $row['email_subject'], "", $row['from_email'], $row['from_name'], "Y",$brand);
		}
	}

	////////////////////////////////////////////////////////////////////
	////////////////////Requisition Mail Section Start//////////////////
	////////////////////////////////////////////////////////////////////

	public function send_email_requisition_raised($uid, $field_array)
	{


		//$eto = 'saikat.ray@omindtech.com,sankha.chowdhury@omindtech.com,sakil.khan@omindtech.com';
		$ecc = "";
		$nbody = "";

		$req_id = $field_array['requisition_id'];
		$off_id = $field_array['location'];
		$raised_by = $field_array['raised_by'];
		$raised_date = $field_array['raised_date'];


		$qSql = "Select *, (select shname from department d where d.id=department_id) as dept_name, (select shname from client c where c.id=client_id) as client_name, (select name from process p where p.id=process_id) as process_name, (select name from role r where r.id=dfr_requisition.role_id) as role_name, (select concat(fname, ' ', lname) as name from signin s where s.id=raised_by) as raised_name from dfr_requisition where requisition_id='" . $req_id . "' ";
		$query = $this->db->query($qSql);
		$dRow = $query->row_array();


		$qSql = "select email_id_off as r_email_id_off, email_id_per as r_email_id_per from info_personal where user_id='" . $raised_by . "' ";
		$query = $this->db->query($qSql);
		$rbRow = $query->row_array();

		// $qSql = "select * from notification_info where sch_for='DFR_REQUISITION-HIRING' and is_active=1 and office_id='" . $off_id . "' ";

		// $query = $this->db->query($qSql);
		// if ($query->num_rows() > 0) {
		// 	$res = $query->row_array();

		$brand = $dRow["company_brand"];
		$site_id = $dRow["site_id"];

		$event = 'DFR_REQUISITION-HIRING';

		$res = get_notification_info($event,$brand,$site_id,$off_id);

		if (count($res) > 0) {
			$asset_approved = $this->getApprovedAssets($dRow['id']);

			$email_subject = $res["email_subject"] . ' - ' . $field_array["requisition_id"];

			$eto=$res["email_id"];
			$ecc = array();

			$ecc[] = $rbRow["r_email_id_off"];
			$ecc[] = $res["cc_email_id"];

			$cc = array_filter($ecc);
			
			$from_email = $res["from_email"];
			$from_name = $res["from_name"];
			$company_hr = $res["signature_text"];

			//$email_id_1 = explode(",",$res["email_id"]);


			$nbody = '
					Dear <b>WFM</b></br></br>
					This is to confirm that Hiring Requisition has been submitted successfully on <b> ' . $field_array["raised_date"] . ' </b>. You are requested to review the hiring numbers and due date. </br> 
					You are hereby requested to approve or reject the requisition with your comment.
	
					</br>
					</br>
							
					Details of Requisition:</br>
					<table border="1" width="80%" cellpadding="0" cellspacing="0">
							<tr>
								<td style="background-color:powderblue;">Requisition Code:</td>
								<td>' . $dRow["requisition_id"] . '</td>
							</tr>
							<tr>
								<td style="background-color:powderblue;">Due Date:</td>
								<td>' . $dRow["due_date"] . '</td>
							</tr>
							<tr>
								<td style="background-color:powderblue;">Batch Code:</td>
								<td>' . $dRow["job_title"] . '</td>
							</tr>
							<tr>
								<td style="background-color:powderblue;">Hiring Nos:</td>
								<td>' . $dRow["req_no_position"] . '</td>
							</tr>
							<tr>
								<td style="background-color:powderblue;">Hiring Manager:</td>
								<td>' . $dRow["raised_name"] . '</td>
							</tr>
							<tr>
								<td style="background-color:powderblue;">Hiring Manager Email:</td>
								<td>' . $rbRow["r_email_id_off"] . '</td>
							</tr>
							<tr>
								<td style="background-color:powderblue;">Department:</td>
								<td>' . $dRow["dept_name"] . '</td>
							</tr>
							<tr>
								<td style="background-color:powderblue;">Client:</td>
								<td>' . $dRow["client_name"] . '</td>
							</tr>
							<tr>
								<td style="background-color:powderblue;">Process:</td>
								<td>' . $dRow["process_name"] . '</td>
							</tr>
							<tr>
								<td style="background-color:powderblue;">Position:</td>
								<td>' . $dRow["role_name"] . '</td>
							</tr>
					</table>
					
				</br>
				</br>
                                  <table border="1" width="80%" cellpadding="0" cellspacing="0">
                                  <tr>
                                  <td colspan="2" style="background-color:powderblue;"><b>Assigned Assets</b></td>
                                  <tr>';
			if (!empty($asset_approved)) {
				foreach ($asset_approved->result() as $approved) {
					$nbody .= '<tr>
                                    <td style="padding:2px 0px 2px 8px">            
                                        ' . $approved->name . '
                                    </td>
                                    <td style="text-align: center;">            
                                            <span >' . $approved->assets_required . '</span>                              
                                    </td>
                                </tr>';
				}
			} else {
				$nbody .= '<tr>
                                <td colspan="2" style="text-align: center;">
                                       No Asset Assigned                             
                                    </td>
                                </tr>';
			}
			$nbody .= '</table>';
			$nbody .= '</br>
						
					Regards, </br>
					'.$company_hr.'	</br>';

			$this->send_email_sox($uid, $eto, implode(',', $cc), $nbody, $email_subject, "", $from_email, $from_name,"",$dRow["company_brand"]);
			
					// ini_set( 'display_errors', 1 );
					// error_reporting( E_ALL );
					// $from = "shilpa.omindtech@gmail.com";
					// $to = "shilpa.omindtech@gmail.com";
					// $subject = "PHP Mail Test script";
					// $message = "This is a test to check the PHP Mail functionality";
					// $headers = "From:" . $from;
					// mail($to,$subject,$message, $headers);
					// echo "Test email sent"; exit;
				}
			}


	public function send_email_candidate_further_review($uid, $field_array, $user_office_id, $r_id, $c_id)
	{

		//$eto = 'saikat.ray@omindtech.com,sankha.chowdhury@omindtech.com,sakil.khan@omindtech.com';
		$ecc = array();
		$nbody = "";


		$qSql = "Select *, concat(fname, ' ', lname) as c_name from dfr_candidate_details where id='" . $c_id . "' ";
		$query = $this->db->query($qSql);
		$cRow = $query->row_array();

		$qSql = "Select *, (select name from role r where r.id=dfr_requisition.role_id) as role_name from dfr_requisition where id='" . $r_id . "' ";
		$query = $this->db->query($qSql);
		$dRow = $query->row_array();

		$off_id = $dRow["location"];
		$site_id = $dRow["site_id"];
		$brand = $dRow["company_brand"];

		// $qSql = "select * from notification_info where sch_for='DFR-CandidateShortlisted' and is_active=1 and office_id='" . $off_id . "' ";

		// $query = $this->db->query($qSql);

		// $config_email = get_mail_config($cRow['company']);

		// $company_name = $config_email['company'];
		// $company_hr = $config_email['company_hr'];


		// if ($query->num_rows() > 0) {
		// 	$res = $query->row_array();
		$event = 'DFR-CandidateShortlisted';

		$res = get_notification_info($event,$brand,$site_id,$off_id);

		if (count($res) > 0) {
			$email_subject = $res["email_subject"] . ' - ' . $cRow["c_name"];

			$eto=$res["email_id"];	

			//$ecc[] = $res["email_id"];
			//$ecc[] = $res["cc_email_id"];

			$cc = array_filter($ecc);


			$file_attachment_path = $cRow["attachment"];

			$attch_file_resume = APPPATH . '../uploads/candidate_resume/' . $file_attachment_path . '';


			//echo $attch_file_resume;


			$from_email = $res["from_email"];
			$from_name = $res["from_name"];


			$nbody = '
					Dear <b>Hiring Manager</b></br></br>
						This is to inform you that ' . $cRow["c_name"] . ' (email: ' . $cRow["email"] . ') has been shortlisted for further review for selection.
						Request you to take appropriate action.			
	
					</br>
					</br>
							
					Details of Requisition:</br>
					<table border="1" width="90%" cellpadding="10px" cellspacing="0" bordercolor="#08a2ba">
						<thead style="background-color:#86dfec;">
							<tr>
								<td>Requisition Code</td>
								<td>Hiring Manager</td>
								<td>Due Date</td>
								<td>Hiring Nos</td>
								<td>Job Title/Designation</td>
								<td>Org. Role</td>
								
							</tr>
						</thead>
						<tbody>
							<tr>
								<td> ' . $dRow["requisition_id"] . ' </td>
								<td> ' . $eto . ' </td>
								<td> ' . $dRow["due_date"] . ' </td>
								<td> ' . $dRow["req_no_position"] . ' </td>
								<td> ' . $dRow["job_title"] . '</td>
								<td> ' . $dRow["role_name"] . '</td>
								
							</tr>
						</tbody>
					</table>
					
					</br>
					</br>
					</br>
						
					Regards, </br>
					'.$company_hr.'</br>
				';


			$this->send_email_sox($uid, $eto, implode(',', $cc), $nbody, $email_subject, $attch_file_resume, $from_email, $from_name);
		}
	}


	public function resend_doc_link($uid, $r_id, $c_id, $doc_link = "")
	{
		
		error_reporting(E_ALL);
        ini_set('display_errors', 1);
		
		$offer_letter = "";
		//$eto = 'saikat.ray@omindtech.com,sankha.chowdhury@omindtech.com,sakil.khan@omindtech.com';
		$ecc = array();
		$nbody = "";


		$qSql = "Select *, concat(fname, ' ', lname) as c_name from dfr_candidate_details where id='" . $c_id . "' ";
		$query = $this->db->query($qSql);
		$cRow = $query->row_array();

		$eto = $cRow["email"];

		$qSql = "Select *, (select name from role r where r.id=role_id) as role_name from dfr_requisition where id='" . $r_id . "' ";
		
				
		$query = $this->db->query($qSql);
		$dRow = $query->row_array();

		$off_id = $dRow["location"];
		$site_id = $dRow["site_id"];
		$brand = $dRow["company_brand"];

		// $qSql = "select * from notification_info where sch_for='DFR-Candidate Selected' and is_active=1 and office_id='" . $off_id . "' ";
		// $query = $this->db->query($qSql);
		// // if($query->num_rows() > 0)
		// // {
		// $res = $query->row_array();


		$event = 'DFR-Candidate Selected';
				
		$res = get_notification_info($event,$brand,$site_id,$off_id);
		

		// if (count($res) > 0) {
		 
		 $email_subject = 'Document Upload Link' . ' - ' . $cRow["c_name"];

		//$eto=$cRow["email"]. ",". $res["email_id"];

		$ecc[] = $res["email_id"];
		$ecc[] = $res["cc_email_id"];
		
		if ($cRow['company'] == 3) {
			$ecc[] = 'omindhr@omindtech.com';
		}


		// $config_email = get_mail_config($cRow['company']);

		// $company_name = $config_email['company'];
		$company_hr = $res['signature_text'];
		$cc = array_filter($ecc);

		$from_email = $res["from_email"];
		$from_name = $res["from_name"];


		$nbody = '
					Dear <b>' . $cRow["c_name"] . '</b></br></br>
						It seems you have not uploaded all the Documents Required.
						</br></br>';

		if ($doc_link != "") {
			//

			$nbody .= "Please Upload Your Documents: <a href='" . $doc_link . "' target='_blank'>Click to Upload Your Documents</a></br></br>";
		}

		$nbody .= 'Looking forward to hearing back from you,

						</br>
						</br>
						</br>
						
					Regards, </br>
					'.$company_hr.'</br>

				';
		

		$this->send_email_sox($uid, $eto, implode(',', $cc), $nbody, $email_subject, $offer_letter, $from_email, $from_name);
	}



	public function send_email_candidate_final_selection($uid, $r_id, $c_id, $offer_letter, $doc_link = "")
	{
		//echo $c_id;die;
		

		//$eto = 'saikat.ray@omindtech.com,sankha.chowdhury@omindtech.com,sakil.khan@omindtech.com';
		$ecc = array();
		$updated_from_email=array();
		$nbody = "";
		//$ecc =add_mail_id_locationwise($c_id);
	


		$qSql = "Select *, concat(fname, ' ', lname) as c_name from dfr_candidate_details where id='" . $c_id . "' ";
		$query = $this->db->query($qSql);
		$cRow = $query->row_array();

		// echo "<pre>"; print_r($cRow); exit;

		$eto = $cRow['email'];

		$qSql = "Select *,ro.name as role_name,mc.name as company_name
		from dfr_requisition r
		LEFT JOIN role ro on ro.id=r.role_id 
		LEFT JOIN master_company mc on mc.id=r.company_brand 
		where r.id='" . $r_id . "' ";
		$query = $this->db->query($qSql);
		$dRow = $query->row_array();

		$site_id = $dRow['site_id'];
		$role_folder = $dRow['folder'];
		$off_id = $dRow["location"];
		$brand = $dRow['company_brand'];

		$event = 'DFR-Candidate Selected';

		$res = get_notification_info($event,$brand,$site_id,$off_id);

		if (count($res) > 0) {

			$email_subject = $res["email_subject"] . ' - ' . $cRow["c_name"];
			
			$updated_from_email[] = $res["from_email"];
			$ecc[] = $res["cc_email_id"];

			if ($cRow['company'] == 3) {
				$ecc[] = 'omindhr@omindtech.com';
			}

			if($role_folder == 'agent'){
				$ecc[] = $res["agent_cc_email_id"];
			}

			$company_name = $dRow['company_name'];
			$company_hr = $res['signature_text'];



			$cc = array_filter($ecc);
			
			//print_r($ecc);die;
			//echo $cc;die;


			$from_email = $res["from_email"];
			$from_name = $res["from_name"];
			//print_r($from_email);die;


			$nbody = '
					Dear <b>' . $cRow["c_name"] . '</b></br></br>
						Thank you for taking the time to talk to us about the <b>' . $dRow["role_name"] . '</b> position. It was a pleasure getting to meet you and we think that you would be a good fit for this role.		
						</br></br>
						
						I am pleased to extend the following offer of employment to you on behalf of '.$company_name.'. You have been selected for the <b>' . $dRow["role_name"] . '</b> position. Congratulations!
						</br></br>
						
						We believe that your knowledge, skills and experience would be an ideal fit for our organization. We hope you will enjoy your role and make a significant contribution to the overall success of '.$company_name.'.
						</br></br>
						
						Please take the time to review our offer. It includes important details about your compensation, benefits and the terms and conditions of your anticipated employment with '.$company_name.'.
						</br></br>';

			if ($doc_link != "") {
				//

				$nbody .= "Please Upload Your Documents: <a href='" . $doc_link . "' target='_blank'>Click to Upload Your Documents</a></br></br>";
			}

			$nbody .= 'Looking forward to hearing back from you,

						</br>
						</br>
						</br>
						
					Regards, </br>
					'.$company_hr.'</br>

				';


				//$this->send_email_sox($uid, $eto, implode(',', $cc), $nbody, $email_subject, $offer_letter, $from_email, $from_name);
				$this->send_email_sox($uid, $eto, implode(',',$cc), $nbody, $email_subject, $offer_letter, $from_email, $from_name);
		}
	}



	public function candidate_schedule($r_id, $field_array)
	{
		$query = $this->db->query('SELECT dfr_interview_schedules.*,CONCAT(dfr_candidate_details.fname," ",dfr_candidate_details.lname) as candidate_name,(SELECT job_title FROM `dfr_requisition` where requisition_id="' . $r_id . '") as job_title,office_location.location,office_location.abbr,dfr_candidate_details.email as c_email,dfr_candidate_details.company as brand,dfr_candidate_details.site_id,mc.name as company_name FROM `dfr_interview_schedules`
		left join dfr_candidate_details on dfr_candidate_details.id=dfr_interview_schedules.c_id
		left join master_company mc on mc.id=dfr_candidate_details.company
		left join office_location on office_location.abbr=dfr_interview_schedules.interview_site WHERE dfr_interview_schedules.c_id="' . $field_array['c_id'] . '" ORDER by dfr_interview_schedules.id DESC');
		$rows = $query->result_object();
		//echo '<pre>';
		//print_r($rows);

		//$hr_query = $this->db->query('SELECT CONCAT(signin.fname," ",signin.lname) AS hr_name,info_personal.email_id_per,info_personal.email_id_off,info_personal.phone FROM `signin`
		//left join info_personal ON info_personal.user_id=signin.id where signin.office_id="'.$rows[0]->abbr.'" and dept_id="3" limit 1');
		//$hr_row = $hr_query->result_object();

		$interview_type = $field_array['interview_type'];
		$assign_interviewer = $field_array['assign_interviewer'];

		$qSql = "select name as round_name from dfr_interview_type_mas where is_active=1 and id='" . $interview_type . "'";
		$query = $this->db->query($qSql);
		$interRound = $query->row_array();

		$qSql = "select role_id, (select name from role r where r.id=role_id) as role_name from dfr_requisition where id='" . $r_id . "'";
		$query = $this->db->query($qSql);
		$roleName = $query->row_array();

		if ($interview_type == 5) {
			$qSql = "select concat(fname, ' ', lname) as name, email_id from signin_client where id='" . $assign_interviewer . "'";
			$query = $this->db->query($qSql);
			$assignInter = $query->row_array();
		} else {
			$qSql = "select concat(fname, ' ', lname) as name, (select email_id_off from info_personal ip where ip.user_id=signin.id) as email_id from signin where id='" . $assign_interviewer . "'";
			$query = $this->db->query($qSql);
			$assignInter = $query->row_array();
		}

		$site_id = $rows[0]->site_id;
		$brand = $rows[0]->brand;

		$off_id = $rows[0]->abbr;
		// exit;

		// $notification_query = $this->db->query("select * from notification_info where sch_for='DFR_CandidateSched' and is_active=1 and office_id='" . $rows[0]->abbr . "' $cond");

		$event = 'DFR_CandidateSched';

		$notification_row = get_notification_info($event,$brand,$site_id,$off_id);

		// echo "<pre>"; print_r($notification_row); exit;

		if (count($notification_row) > 0) {
			$to = $rows[0]->c_email;
			$cc = array();
			$cc[] = $notification_row['email_id'];
			$cc[] = $notification_row['cc_email_id'];
			$cc[] = $assignInter['email_id'];
			
			$ecc = array_filter($cc);

			$email_subject = $notification_row['email_subject'];

			$nbody = "Dear <b>" . $rows[0]->candidate_name . "</b>, </br></br>";

			$company_name = $rows[0]->company_name;
			$company_hr = $notification_row['signature_text'];

			if ($rows[0]->abbr == "JAM") {

				$nbody .= "Fusion BPO Services Jamaica would like thank you for applying to our Company and hereby invite you to a scheduled interview on <b>" . date('l, F d, Y', strtotime($rows[0]->scheduled_on)) . " at " . date('h:i A', strtotime($rows[0]->scheduled_on)) . "</b> at our Head Office located at 153 Orange Street, Kingston to meet with our Recruitment Team. </br></br>";
			} else {
				$nbody .= "<span>Your application for <b>'" . $roleName['role_name'] . "'</b> position stood out to us and we would like to invite you for an interview on <b>" . $rows[0]->scheduled_on . "</b> at <b>Time</b> at our office in <b>" . $rows[0]->location . "</b>.</span> </br></br>";
			}


			$nbody .= "You will have the <b>'" . $interRound['round_name'] . "'</b> with <b>'" . $assignInter['name'] . "'</b>.";

			$nbody .= $notification_row['email_body'] . "</br></br>";

			$nbody .= "<b>Regards</b>, </br>
			<b>$company_hr</b></br>";

			return $this->send_email_sox($field_array['creation_by'], $to, implode(',', $ecc), $nbody, $email_subject);
		}
	}
	public function hiring_requis_decline($uid, $r_id, $field_array)
	{
		$query = $this->db->query('SELECT requisition_id,location,due_date,raised_by,signin.fname,signin.lname,req_no_position,job_title,role.name as role,approved_comment,info_personal.email_id_off as raised_by_email,department.shname,dfr_requisition.company_brand as brand,dfr_requisition.site_id FROM dfr_requisition
		left join signin on signin.id=dfr_requisition.raised_by
		left join info_personal on info_personal.user_id=dfr_requisition.raised_by
		left join department on department.id=dfr_requisition.department_id
		left join role ON role.id=dfr_requisition.role_id where dfr_requisition.id="' . $r_id . '"');
		$rows = $query->row_array();
		$office_location = $rows['location'];
		$requisition_id = $rows['requisition_id'];
		$due_date = $rows['due_date'];
		$req_no_position = $rows['req_no_position'];
		$job_title = $rows['job_title'];
		$role = $rows['role'];
		$hir_manager = $rows['fname'] . ' ' . $rows['lname'];
		$site_id = $rows['site_id'];
		$brand = $rows['brand'];
		// $qSql = "select * from notification_info where sch_for='DFR_HirRequiRejec' and is_active=1 and office_id='" . $office_location . "'";

		// $query = $this->db->query($qSql);
		// $res = $query->row_array();


		$event = 'DFR_HirRequiRejec';

		$res = get_notification_info($event,$brand,$site_id,$office_location);
		if (count($res) > 0) {
			$cc = array();
			$to = $res["email_id"];
			$cc[] = $res["cc_email_id"];
			$cc[] = $rows["raised_by_email"];
			$department = $rows["shname"];
			$update_comment = $rows["update_comment"];
			
			$ecc = array_filter($cc);
			$email_subject = $res["email_subject"] . ' - ' . $requisition_id;

			$nbody = "Dear <b>WFM</b>, </br></br>
			<span>This is to confirm that Hiring Requisition has been rejected on <b>" . date('Y-m-d') . "</b> by <b>WFM</b>.
			are requested to get in touch with WFM spoc for further information.</span>";

			$nbody .= "</br></br>Additional comment by WFM on rejection </br>
			<b>" . $update_comment . "</b><br><br>";

			$nbody .= 'Requisition <b>' . $requisition_id . '</b> can be reopened. </br>
			Please raise a revised Hiring Requisition, please get in touch with WFM SPOC for the requirements & projections.</br>';

			return $this->send_email_sox($uid, $to, implode(',', $ecc), $nbody, $email_subject);
		}
	}
	public function hiring_requis_approve($uid, $r_id, $field_array)
	{
		$query = $this->db->query('SELECT requisition_id,location,due_date,raised_by,dfr_requisition.id,
                    signin.fname,signin.lname,req_no_position,job_title,role.name as role,
                    approved_comment,info_personal.email_id_off as raised_by_email,department.shname,dfr_requisition.company_brand as brand,dfr_requisition.site_id
                    FROM dfr_requisition
		left join signin on signin.id=dfr_requisition.raised_by
		left join info_personal on info_personal.user_id=dfr_requisition.raised_by
		left join department on department.id=dfr_requisition.department_id
		left join role ON role.id=dfr_requisition.role_id where dfr_requisition.id="' . $r_id . '"');

		$rows = $query->row_array();
		$office_location = $rows['location'];
		$requisition_id = $rows['requisition_id'];
		$due_date = $rows['due_date'];
		$req_no_position = $rows['req_no_position'];
		$job_title = $rows['job_title'];
		$role = $rows['role'];
		$hir_manager = $rows['fname'] . ' ' . $rows['lname'];

		$site_id = $rows['site_id'];
		$brand = $rows['brand'];
		
		// $check_site_id = array('34','35');
		
		// $cond = "";
		// if($brand == 3) $cond .=" and brand_id = 3";
		// if(in_array($site_id, $check_site_id)) $cond .=" and site_id = $site_id";

		// $qSql = "select * from notification_info where sch_for='DFR_HirRequiAppro' and is_active=1 and office_id='" . $office_location . "' $cond";


		$event = 'DFR_HirRequiAppro';

		$res = get_notification_info($event,$brand,$site_id,$office_location);

		// $query = $this->db->query($qSql);
		// $res = $query->row_array();
		if (count($res) > 0) {
			$asset_approved = $this->getApprovedAssets($r_id);
			$cc = array();
			$to = $res["email_id"];
			$cc[] = $res["cc_email_id"];
			$cc[] = $rows["raised_by_email"];

			$company_hr = $res["signature_text"];

			$company_hr = str_replace('HR Shared Services', '-', $company_hr);
			$department = $rows["shname"];
			$update_comment = $rows["approved_comment"];
			
			$ecc = array_filter($cc);
			$email_subject = $res["email_subject"] . ' - ' . $requisition_id;

			$nbody = "Dear <b>Hr</b>, </br></br>
			<span>This is to confirm that Hiring Requisition has been approved successfully on <b>" . date('Y-m-d') . "</b> by <b>WFM</b>.
			You are requested to the hiring and update the progress in MWP portal.</span><br>";

			$nbody .= "<br>Additional comment by WFM</br>
			<b>" . $update_comment . "</b><br><br>";

			$nbody .= 'Details of Requisition:
			<table border="1" width="80%" cellpadding="0" cellspacing="0">
				<thead style="background-color:powderblue;">
					<tr>
						<td>Requisition Code</td>
						<td>Hiring Manager</td>
						<td>Due Date</td>
						<td>Hiring Nos</td>
						<td>Job Title/Designation</td>
						<td>Organization role</td>
					</tr>
				<thead>
				<tbody>
					<tr>
						<td>' . $requisition_id . '</td>
						<td>' . $hir_manager . '</td>
						<td>' . $due_date . '</td>
						<td>' . $req_no_position . '</td>
						<td>' . $job_title . '</td>
						<td>' . $role . '</td>
					</tr>
				</tbody>
			</table><br>     <table border="1" width="80%" cellpadding="0" cellspacing="0">
                                  <tr>
                                  <td colspan="2" style="background-color:powderblue;"><b>Assigned Assets</b></td>
                                  <tr>';
			if (!empty($asset_approved)) {
				foreach ($asset_approved->result() as $approved) {
					$nbody .= '<tr>
                                    <td style="padding:2px 0px 2px 8px">            
                                        ' . $approved->name . '
                                    </td>
                                    <td style="text-align: center;">            
                                            <span >' . $approved->assets_required . '</span>                              
                                    </td>
                                </tr>';
				}
			} else {
				$nbody .= '<tr>
                                <td colspan="2" style="text-align: center;">
                                       No Asset Assigned                             
                                    </td>
                                </tr>';
			}
			$nbody .= '</table>';
			$nbody .= '</br><b>Regards,</b> </br>
			<b>'.$company_hr.'WFM Team.</b></br>';

			// SEND HIRING ASIGN TRAINER
			//$this->hiring_assign_trainer($uid,$r_id);

			return $this->send_email_sox($uid, $to, implode(',', $ecc), $nbody, $email_subject);
		}
	}


	public function hiring_assign_trainer($uid, $r_id)
	{

		//

		$query = $this->db->query('SELECT d.requisition_id, d.location, d.department_id, d.role_id,d.company_brand as brand ,r.folder, 
		                            d.raised_by, d.due_date, d.req_no_position, d.job_title, r.name as role_name, 
									concat(rs.fname, " ", rs.lname) as raised_by_name, p.email_id_off as raised_by_email,d.company_brand as brand,d.site_id
									from dfr_requisition as d 
									LEFT JOIN role as r on r.id = d.role_id 
									LEFT JOIN signin as rs on rs.id = d.raised_by 
									LEFT JOIN info_personal as p ON p.user_id = d.raised_by
									WHERE d.id = "' . $r_id . '"');
		$rows = $query->row_array();
		$office_location    = $rows['location'];
		$requisition_id     = $rows['requisition_id'];
		$hir_manager_name   = $rows['raised_by_name'];
		$hir_manager_email  = $rows['raised_by_email'];
		$hir_manager_id     = $rows['raised_by'];
		$requisition_folder = $rows['folder'];
		$due_date           = $rows['due_date'];
		$req_no_position    = $rows['req_no_position'];
		$job_title          = $rows['job_title'];
		$role               = $rows['role_name'];
		$department_id      = $rows['department_id'];
		$brand				= $rows['company_brand'];

		$current_to_emailid = $hir_manager_email;
		$l1_msg = " L1 Supervisor ";


		if ($requisition_folder == "agent" && $department_id == '6') {
			$querydata = $this->db->query('SELECT GROUP_CONCAT(p.email_id_off) as emailids from signin as s
											LEFT JOIN info_personal as p ON p.user_id = s.id
											WHERE s.role_id IN (SELECT id from role WHERE folder = "manager") 
											AND s.dept_id = "11" 
											AND s.office_id = "' . $office_location . '"
											AND (p.email_id_off <> "" AND p.email_id_off is NOT NULL)');
			$rowsdata = $querydata->row_array();
			$current_to_emailid = $rowsdata['emailids'];
			$l1_msg = " Trainer ";
			if ($current_to_emailid == "") {
				$current_to_emailid = $hir_manager_email;
			}
		}


		$site_id = $rows['site_id'];
		$brand = $rows['brand'];
		
		// $check_site_id = array('34','35');
		
		// $cond = "";
		// if($brand == 3) $cond .=" and brand_id = 3";
		// if(in_array($site_id, $check_site_id)) $cond .=" and site_id = $site_id";


		// $qSql = "select * from notification_info where sch_for='DFR_ASSIGN' and is_active=1 and office_id='" . $office_location . "'$cond";


		$event = 'DFR_ASSIGN';

		$res = get_notification_info($event,$brand,$site_id,$office_location);

		$query = $this->db->query($qSql);
		if (count($res) > 0) {
			// $res = $query->row_array();
			$company_hr = $res["signature_text"];

			$company_hr = str_replace('HR Shared Services', '-', $company_hr);
			$cc = array();
			$to = $current_to_emailid;
			$cc[] = $res["cc_email_id"];
			$ecc = array_filter($cc);
			
			//$email_subject = $res["email_subject"].' - '.$requisition_id;

			$email_subject = $res["email_subject"] . ' - ' . $requisition_id;

			$nbody = "<b>Hi,</b></br></br>
			<span>Please Update, assign the $l1_msg on the Requisition # " . $requisition_id . "</span><br>";

			$nbody .= 'Details of Requisition:
			<table border="1" width="80%" cellpadding="0" cellspacing="0">
				<thead style="background-color:powderblue;">
					<tr>
						<td>Requisition Code</td>
						<td>Hiring Manager</td>
						<td>Due Date</td>
						<td>Hiring Nos</td>
						<td>Job Title/Designation</td>
						<td>Organization role</td>
					</tr>
				<thead>
				<tbody>
					<tr>
						<td>' . $requisition_id . '</td>
						<td>' . $hir_manager_name . '</td>
						<td>' . $due_date . '</td>
						<td>' . $req_no_position . '</td>
						<td>' . $job_title . '</td>
						<td>' . $role . '</td>
					</tr>
				</tbody>
			</table><br>';

			$nbody .= '<b>Regards,</b> </br>
			<b>'.$company_hr.'WFM Team.</b></br>';

			return $this->send_email_sox($uid, $to, implode(',', $ecc), $nbody, $email_subject,"","","","",$brand);
		}
	}


	/*-----------------Handover Mail Section---------------------*/

	public function send_email_operation_handover_requisition($req_id, $hiring_manager)
	{
		//$to = 'saikat.ray@omindtech.com,sankha.chowdhury@omindtech.com,sakil.khan@omindtech.com';
		$nbody = "";

		$qSql = "SELECT * from 
				(Select id, dfr_id, fusion_id, xpoid, concat(fname, ' ', lname) as name, doj, get_client_names(id) as client, get_process_names(id) as process, (select name from role r where r.id=role_id) as role_name from signin where dfr_id in (select id from dfr_candidate_details where r_id='" . $req_id . "' and candidate_status='E') ) xx Left Join (Select user_id, phone from info_personal) yy On (xx.id=yy.user_id) 
				Left Join (select id as cid, r_id, (select requisition_id from dfr_requisition dr where dr.id=r_id) as requisitionId, (select job_title from dfr_requisition dr where dr.id=r_id) as jobTitle, (select due_date from dfr_requisition dr where dr.id=r_id) as dueDate, (select location from dfr_requisition dr where dr.id=r_id) as offLocation from dfr_candidate_details) zz on (xx.dfr_id=zz.cid)";
		$query = $this->db->query($qSql);
		$candReqTable = $query->result_array();

		$qSql = "Select * from dfr_requisition where id='" . $req_id . "' ";
		$query = $this->db->query($qSql);
		$reqDetails = $query->row_array();

		$qSql = "Select email_id_off, email_id_per from info_personal where user_id='" . $hiring_manager . "' ";
		$query = $this->db->query($qSql);
		$toEmailId = $query->row_array();

		$site_id = $reqDetails['site_id'];
		$brand = $reqDetails['company_brand'];
		
		// $check_site_id = array('34','35');
		
		// $cond = "";
		// if($brand == 3) $cond .=" and brand_id = 3";
		// if(in_array($site_id, $check_site_id)) $cond .=" and site_id = $site_id";

		// $qSql = "select * from notification_info where sch_for='Handover_HR_to_Training' and is_active=1 and office_id='" . $reqDetails['location'] . "' $cond";

		$office_location = $reqDetails['location'];

		$event = 'Handover_HR_to_Training';

		$res = get_notification_info($event,$brand,$site_id,$office_location);


		// $query = $this->db->query($qSql);
		if (count($res) > 0) {
			// $res = $query->row_array();
			// $company_name = $rows[0]->company_name;
			$company_hr = $res['signature_text'];

			$email_subject = $res["email_subject"] . ' - Production - ' . $reqDetails["job_title"] . ' - ' . $reqDetails["requisition_id"];

			$eto = array();
			$eto[] = $res["email_id"];
			$eto[] = $toEmailId['email_id_off'];
			$to = array_filter($eto);
			
			$ecc = array();
			$ecc[] = $res["cc_email_id"];
			$cc = array_filter($ecc);


			$from_email = $res["from_email"];
			$from_name = $res["from_name"];


			$nbody = '
					Hi Team, </br>
					Please find the list of users for the Batch ' . $reqDetails["job_title"] . ', against the Requisition code ' . $reqDetails["requisition_id"] . '. 
	
					</br>
					</br>
							
					It is an auto acknowledgement mail.</br></br>
					<table border="1" width="100%" cellpadding="0" cellspacing="0">
						<thead>
							<tr style="background-color:#86dfec;">
								<td>Requisition Code</td>
								<td>Batch Code</td>
								<td>Due date</td>
								<td>DOJ</td>
								<td>MWP ID</td>
								<td>XPOID</td>
								<td>NAME</td>
								<td>Contact No</td>
								<td>Client</td>
								<td>Process</td>
								<td>Designation</td>
							</tr>
						</thead>
						<tbody>';

			foreach ($candReqTable as $value) {

				$nbody .= '<tr>
								<td>' . $value["requisitionId"] . '</td>
								<td>' . $value["jobTitle"] . '</td>
								<td>' . $value["dueDate"] . '</td>
								<td>' . $value["doj"] . '</td>
								<td>' . $value["fusion_id"] . '</td>
								<td>' . $value["xpoid"] . '</td>
								<td>' . $value["name"] . '</td>
								<td>' . $value["phone"] . '</td>
								<td>' . $value["client"] . '</td>
								<td>' . $value["process"] . '</td>
								<td>' . $value["role_name"] . '</td>
							</tr>';
			}

			$nbody .= '</tbody>
							
					</table>
					
				</br>
				</br>
						
					Regards, </br>
					'.$company_hr.'	</br>
				';
			$this->send_email_sox($uid, implode(',', $to), implode(',', $cc), $nbody, $email_subject, "", $from_email, $from_name,"",$reqDetails["company_brand"]);
		}
	}


	public function send_email_support_handover_requisition($req_id, $hiring_manager, $assigned_to)
	{
		//$eto = 'saikat.ray@omindtech.com,sankha.chowdhury@omindtech.com,sakil.khan@omindtech.com';
		$nbody = "";

		$qSql = "SELECT * from 
				(Select id, dfr_id, fusion_id, xpoid, concat(fname, ' ', lname) as name, doj, get_client_names(id) as client, get_process_names(id) as process, (select name from role r where r.id=role_id) as role_name, (select description from department d where d.id=dept_id) as dept_name from signin where dfr_id in (select id from dfr_candidate_details where r_id='" . $req_id . "' and candidate_status='E') ) xx Left Join (Select user_id, phone from info_personal) yy On (xx.id=yy.user_id) 
				Left Join (select id as cid, r_id, (select requisition_id from dfr_requisition dr where dr.id=r_id) as requisitionId, (select job_title from dfr_requisition dr where dr.id=r_id) as jobTitle, (select due_date from dfr_requisition dr where dr.id=r_id) as dueDate, (select location from dfr_requisition dr where dr.id=r_id) as offLocation from dfr_candidate_details) zz on (xx.dfr_id=zz.cid)";
		$query = $this->db->query($qSql);
		$candReqTable = $query->result_array();

		$qSql = "Select * from dfr_requisition where id='" . $req_id . "' ";
		$query = $this->db->query($qSql);
		$reqDetails = $query->row_array();

		$site_id = $reqDetails['site_id'];
		$brand = $reqDetails['company_brand'];
		
		// $check_site_id = array('34','35');
		
		// $cond = "";
		// if($brand == 3) $cond .=" and brand_id = 3";
		// if(in_array($site_id, $check_site_id)) $cond .=" and site_id = $site_id";

		$qSql = "Select email_id_off, email_id_per from info_personal where user_id='" . $hiring_manager . "' ";
		$query = $this->db->query($qSql);
		$toEmailId = $query->row_array();

		$qSql = "Select email_id_off, email_id_per from info_personal where user_id='" . $assigned_to . "' ";
		$query = $this->db->query($qSql);
		$toLSuperEmailId = $query->row_array();

		// $qSql = "select * from notification_info where sch_for='Handover_HR_to_Support' and is_active=1 and office_id='" . $reqDetails['location'] . "' $cond";
		// $query = $this->db->query($qSql);
		$office_location = $reqDetails['location'];

		$event = 'Handover_HR_to_Support';

		$res = get_notification_info($event,$brand,$site_id,$office_location);


		// $query = $this->db->query($qSql);
		if (count($res) > 0) {
			$company_hr = $res['signature_text'];
			$email_subject = $res["email_subject"] . ' - ' . $reqDetails["requisition_id"];

			$eto=$toEmailId['email_id_off'].','.$toLSuperEmailId['email_id_off'];

			$ecc = array();
			$ecc[] = $res["cc_email_id"];
			$cc = array_filter($ecc);


			$from_email = $res["from_email"];
			$from_name = $res["from_name"];


			$nbody = '
					Hi Team, </br>
					Please find the list of users against the Requisition code ' . $reqDetails["requisition_id"] . ' has been on boarded and handed over to you.
					</br>
					</br>
							
					It is an auto acknowledgement mail.</br></br>
					<table border="1" width="100%" cellpadding="0" cellspacing="0">
						<thead>
							<tr style="background-color:#86dfec;">
								<td>Requisition Code</td>
								<td>Batch Code</td>
								<td>Due date</td>
								<td>DOJ</td>
								<td>MWP ID</td>
								<td>XPOID</td>
								<td>NAME</td>
								<td>Contact No</td>
								<td>Department</td>
								<td>Designation</td>
							</tr>
						</thead>
						<tbody>';

			foreach ($candReqTable as $value) {

				$nbody .= '<tr>
								<td>' . $value["requisitionId"] . '</td>
								<td>' . $value["jobTitle"] . '</td>
								<td>' . $value["dueDate"] . '</td>
								<td>' . $value["doj"] . '</td>
								<td>' . $value["fusion_id"] . '</td>
								<td>' . $value["xpoid"] . '</td>
								<td>' . $value["name"] . '</td>
								<td>' . $value["phone"] . '</td>
								<td>' . $value["dept_name"] . '</td>
								<td>' . $value["role_name"] . '</td>
							</tr>';
			}

			$nbody .= '</tbody>
							
					</table>
					
				</br>
				</br>
						
					Regards, </br>
					'.$company_hr.'	</br>
				';
			$this->send_email_sox($uid, $eto, implode(',', $cc), $nbody, $email_subject, "", $from_email, $from_name,"",$reqDetails["company_brand"]);
		}
	}


	////////////////////////////////////////////////////////////////////
	////////////////////Requisition Mail Section End////////////////////
	////////////////////////////////////////////////////////////////////




	//////////////////////////////////////////////////////////////////////
	////////////////////Resign section email start////////////////////////
	//////////////////////////////////////////////////////////////////////

	//This Model Is Done & Working Fine
	public function remind_resignation($array)
	{
		$qSql = 'SELECT role.name as role_name, department.shname as dept_name,signin.brand as brand,signin.site_id ,signin.doj,role_organization.name as role_organization, info_personal.email_id_off, info_personal.email_id_per, concat(signin.fname," ",signin.lname) as name, get_client_names(signin.id) as client_name, get_process_names(signin.id) as process_name, info_personal.user_id,signin.fusion_id,signin.assigned_to,b.email_id_off as l1_email_off,b.email_id_per as l1_email_per FROM info_personal
			left join signin on signin.id=info_personal.user_id
			left join info_personal as b on b.user_id=signin.assigned_to
			left join role on role.id=signin.role_id
			left join department on department.id=signin.dept_id
			left join role_organization on role_organization.id=signin.org_role_id
		WHERE info_personal.user_id="' . $array->user_id . '"';

		//echo $qSql;

		$query = $this->db->query($qSql);
		$uRow = $query->row_array();

		$role_name = $uRow["role_name"];
		$client_name = $uRow["client_name"];
		$dept_name = $uRow["dept_name"];
		$process_name = $uRow["process_name"];

		$doj = $uRow["doj"];
		$brand = $uRow["brand"];

		$role_organization = $uRow["role_organization"];
		$email_id_off = $uRow["email_id_off"];
		$email_id_per = $uRow["email_id_per"];
		$name = $uRow["name"];

		$fusion_id = $uRow["fusion_id"];

		$l1_email_off = $uRow["l1_email_off"];
		$l1_email_per = $uRow["l1_email_per"];
		$l1_id = $uRow["assigned_to"];

		$qSql = "SELECT email_id_off as value FROM `info_personal` WHERE user_id = (select assigned_to from signin where id='" . $l1_id . "');";
		$l2_email_off = $this->Common_model->get_single_value($qSql);


		$site_id = $uRow['site_id'];
		$brand = $uRow['brand'];
		
		// $check_site_id = array('34','35');
		
		// $cond = "";
		// if($brand == 3) $cond .=" and brand_id = 3";
		// if(in_array($site_id, $check_site_id)) $cond .=" and site_id = $site_id";

		// $qSql = "select * from notification_info where sch_for='RemindResign' and is_active=1 and office_id='" . $array->office_id . "'$cond";




		// $query = $this->db->query($qSql);
		// /* echo '<pre>';
		// print_r($query);
		// die(); */
		// if ($query->num_rows() > 0) {


		$office_location = $array->office_id;

		$event = 'RemindResign';

		$res = get_notification_info($event,$brand,$site_id,$office_location);


		// $query = $this->db->query($qSql);
		if (count($res) > 0) {
			// $res = $query->row_array();
			$email_subject = $res["email_subject"] . ' - ' . $name . ' - ' . $fusion_id;
			$company_hr = $res['signature_text'];
			$email_id = $eto = $res["email_id"];
			$ecc = array();

			$ecc[] = $res["cc_email_id"];
			$ecc[] = $l1_email_off;
			$ecc[] = $l2_email_off;
			$cc = array_filter($ecc);



			$from_email = $res["from_email"];
			$from_name = $res["from_name"];

			$nbody = "Dear, </br></br>
			<span>This is to inform you that <b>" . $name . "</b> (Fusion ID: <b>" . $fusion_id . "</b>) has submitted resignation through online resignation module. </br>
			Request you to contact " . $name . " and take appropriate action.</span><br>";

			$nbody .= "Details of Resignation:<br>";
			$nbody .= '<table border="1" width="80%" cellpadding="0" cellspacing="0">
				<thead style="background-color:powderblue;">
					<tr>
						<td>Employee ID</td>
						<td>Employee Name</td>
						<td>Client</td>
						<td>Process</td>
						<td>Department</td>
						<td>Designation</td>
						<td>Date of Resignation</td>
						<td>Reason/ Remarks</td>
						<td>Requested Relieving Date</td>
						<td>Date of joining</td>
						<td>Organization role</td>
						<td>Employment status (Permanent/Probationer)</td>
					</tr>
				<thead>
				<tbody>
					<tr>
						<td>' . $fusion_id . '</td>
						<td>' . $name . '</td>
						<td>' . $client_name . '</td>
						<td>' . $process_name . '</td>
						<td>' . $dept_name . '</td>
						<td>' . $role_name . '</td>
						<td>' . $array->resign_date . '</td>
						<td>' . $array->user_remarks . '</td>
						<td>' . $array->released_date . '</td>
						<td>' . $doj . '</td>
						<td>' . $role_organization . '</td>
						<td>Permanent</td>
					</tr>
				</tbody>
			</table>';

			$nbody .= "</br>For updating the exit kindly follow the path: <a href='https://fems.fusionbposervices.com/fems/' target='_blank'>https://fems.fusionbposervices.com/fems/</a> - select Resignation.</br></br>";

			$nbody .= "<b>Regards,</b> </br>
			<b>$company_hr</b></br>";

			//$esubject = $site_name ." - ". $esubject;

			//$esubject=$site_name ." - ".$process_name . " / ". $esubject . " / ".$full_name." / ".$omuid;

			return $this->send_email_sox($array->user_id, $email_id, implode(',', $cc), $nbody, $email_subject, "", $from_email, $from_name,"",$brand);
		}
	}


	public function send_email_resignation_hr_accept($uid, $field_array, $user_office_id)
	{
		$qSql = 'SELECT role.name as role_name,signin.doj,signin.brand,office_id, signin.site_id,role_organization.name as role_organization, info_personal.email_id_off, info_personal.email_id_per, concat(signin.fname," ",signin.lname) as name,info_personal.user_id,signin.fusion_id,signin.assigned_to,b.email_id_off as l1_email_off,b.email_id_per as l1_email_per FROM info_personal
		left join signin on signin.id=info_personal.user_id
        left join info_personal as b on b.user_id=signin.assigned_to
        left join role on role.id=signin.role_id
        left join role_organization on role_organization.id=signin.org_role_id
		WHERE info_personal.user_id="' . $uid . '"';

		//echo $qSql;

		$query = $this->db->query($qSql);
		$uRow = $query->row_array();

		$role_name = $uRow["role_name"];
		$doj = $uRow["doj"];

		$role_organization = $uRow["role_organization"];
		$email_id_off = $uRow["email_id_off"];
		$email_id_per = $eto = $uRow["email_id_per"];/*//'saikat.ray@omindtech.com,sankha.chowdhury@omindtech.com,sakil.khan@omindtech.com'; //*/
		$name = $uRow["name"];

		$fusion_id = $uRow["fusion_id"];
		$l1_email_off = $uRow["l1_email_off"];
		$l1_email_per = $uRow["l1_email_per"];
		$l1_id = $uRow["assigned_to"];

		$qSql = "SELECT email_id_off as value FROM `info_personal` WHERE user_id = (select assigned_to from signin where id='" . $l1_id . "');";
		$l2_email_off = $this->Common_model->get_single_value($qSql);

		$qSql = "SELECT resign_date as value FROM user_resign WHERE  user_id = '" . $uid . "' and resign_status = 'AC' order by id desc limit 1;";
		$resign_date = $this->Common_model->get_single_value($qSql);

		$site_id = $uRow['site_id'];
		$brand = $uRow['brand'];
		$office_id = $uRow['office_id'];
		// $check_site_id = array('34','35');
		
		// $cond = "";
		// if($brand == 3) $cond .=" and brand_id = 3";
		// if(in_array($site_id, $check_site_id)) $cond .=" and site_id = $site_id";

		// $qSql = "select * from notification_info where sch_for='ResignAccept' and is_active=1 and office_id='" . $user_office_id . "'$cond";

		// $query = $this->db->query($qSql);
		// /* echo '<pre>';
		// print_r($query);
		// die(); */
		// if ($query->num_rows() > 0) {
		// $office_location = $array->office_id;

		$event = 'ResignAccept';

		$res = get_notification_info($event,$brand,$site_id,$office_id);


		// $query = $this->db->query($qSql);
		if (count($res) > 0) {
			// $res = $query->row_array();
			$email_subject = $res["email_subject"] . ' - ' . $name . ' - ' . $fusion_id;
			$ecc = array();
			$ecc[] = $res["email_id"];
			$ecc[] = $res["cc_email_id"];
			$ecc[] = $l1_email_off;
			$ecc[] = $l2_email_off;

			$company_hr = $res['signature_text'];

			$cc = array_filter($ecc);

			$from_email = $res["from_email"];
			$from_name = $res["from_name"];

			$nbody = "Dear <b>" . $name . "</b>, </br></br>
			<span>Please be informed that your resignation has been accepted and your last working date has been updated as <b>" . $field_array['accepted_released_date'] . "</b> by your HR, with reference to your resignation dated <b>" . $resign_date . "</b>.</span><br>";

			$nbody .= "Kindly complete all separation formalities prior to your last working day. </br>
			Please refer the attached document/s for clearance guidelines. </br> </br>
			
			<b>We wish you the very best in all your future endeavors!<b></br></br></br>";
			$nbody .= "<b>Regards,</b> </br>
			<b>$company_hr</b></br>";

			//$esubject = $site_name ." - ". $esubject;

			//$esubject=$site_name ." - ".$process_name . " / ". $esubject . " / ".$full_name." / ".$omuid;

			$this->send_email_sox($uid, $email_id_per, implode(',', $cc), $nbody, $email_subject, "", $from_email, $from_name,"Y",$brand);
			
		}
	}


	//This Model Is Done & Working Fine
	public function send_email_resignation($uid, $field_array, $user_office_id)
	{
		$eto = "";
		$ecc = array();
		$nbody = "";

		$qSql = 'SELECT role.name as role_name,signin.doj,signin.brand as brand,signin.site_id,role_organization.name as role_organization, info_personal.email_id_off, info_personal.email_id_per, concat(signin.fname," ",signin.lname) as name, department.shname as dept_name, get_client_names(signin.id) as client_name, get_process_names(signin.id) as process_name, info_personal.user_id, signin.fusion_id, signin.assigned_to,(Select email_id_off from info_personal inper where inper.user_id=signin.assigned_to ) as l1_email FROM info_personal
						left join signin on signin.id=info_personal.user_id
						left join department on department.id=signin.dept_id
                        left join role on role.id=signin.role_id
                        left join role_organization on role_organization.id=signin.org_role_id
					WHERE info_personal.user_id="' . $uid . '"';



		$query = $this->db->query($qSql);
		$uRow = $query->row_array();
		/* echo '<pre>';
		print_r($uRow); */

		$role_name = $uRow["role_name"];
		$dept_name = $uRow["dept_name"];
		$client_name = $uRow["client_name"];
		$process_name = $uRow["process_name"];
		$brand=$uRow["brand"];
		$doj = $uRow["doj"];

		$role_organization = $uRow["role_organization"];

		$email_id_off = $field_array['user_email'];
		$email_id_per = ""; //$uRow["email_id_per"];

		

		$l1_email_off = ""; //$uRow["l1_email"];
		$l1_id = $uRow["assigned_to"];

		if ($email_id_per == '') {
			$email_id_per = $field_array['user_email'];
		}
		$name = $uRow["name"];

		$fusion_id = $uRow["fusion_id"];

		$qSql = "SELECT email_id_off as value FROM `info_personal` WHERE user_id = (select assigned_to from signin where id='" . $l1_id . "');";

		$l2_email_off = ""; // $this->Common_model->get_single_value($qSql);

		$site_id = $uRow['site_id'];
		$brand = $uRow['brand'];
		
		// $check_site_id = array('34','35');
		
		// $cond = "";
		// if($brand == 3) $cond .=" and brand_id = 3";
		// if(in_array($site_id, $check_site_id)) $cond .=" and site_id = $site_id";

		// $qSql = "select * from notification_info where sch_for='Resignation' and is_active=1 and office_id='" . $user_office_id . "'$cond";

		// $query = $this->db->query($qSql);
		// $res = $query->row_array();
		// /* print_r($res);
		// print_r($field_array);
		// die(); */
		// if ($query->num_rows() > 0) {

		$event = 'Resignation';

		$res = get_notification_info($event,$brand,$site_id,$user_office_id);


		// $query = $this->db->query($qSql);
		if (count($res) > 0) {
			//update user personal email
			$this->db->query('UPDATE info_personal SET email_id_per = "' . $email_id_per . '" WHERE user_id = "' . $uid . '"');

			//$res = $query->row_array();
			$email_subject = $res["email_subject"] . ' - ' . $name . ' - ' . $fusion_id;

			$ecc = array();
			$ecc[] = $res["email_id"];
			$ecc[] = $res["cc_email_id"];

			$ecc[] = $l1_email_off;
			$ecc[] = $l2_email_off;
			$company_hr = $res['signature_text'];
			$cc = array_filter($ecc);


			$from_email = $res["from_email"];
			$from_name = $res["from_name"];

			$nbody = "Dear <b>" . $name . "</b>, </br></br>
			<span>This is to confirm that your resignation has been submitted successfully on <b>" . date('Y-m-d') . "</b>.
			Your requested release date has been noted. However, your actual release date would be updated by your HR. </br>
			Please refer to the attached document for clearance guidelines. You are hereby advised to continue to adhere to all Fusion policies and </br>
			the confidentiality commitments as employee.</span><br>";

			$nbody_hr .= "Dear All, </br></br>
			This is to inform you that <b>" . $name . "</b> (MWP ID: <b>" . $fusion_id . "</b>) has submitted resignation through online resignation module. </br></br>
			Request you to contact " . $name . " and take appropriate action.<br></br>";

			$nbody_hr .= "Details of Resignation:<br>";

			$nbody_hr .= '<table border="1" width="80%" cellpadding="0" cellspacing="0">
				<tbody>
					<tr>
						<td style="background-color:powderblue;">Employee ID : </td>
						<td>' . $fusion_id . '</td>
					</tr>
					
					<tr>
						<td style="background-color:powderblue;">Employee Name : </td>
						<td>' . $name . '</td>
					</tr>
					<tr>
						<td style="background-color:powderblue;">Department : </td>
						<td>' . $dept_name . '</td>
					</tr>
					
					<tr>
						<td style="background-color:powderblue;">Designation : </td>
						<td>' . $role_name . '</td>
					</tr>
					<tr>
						<td style="background-color:powderblue;">Client : </td>
						<td>' . $client_name . '</td>
					</tr>
					<tr>
						<td style="background-color:powderblue;">Process : </td>
						<td>' . $process_name . '</td>
					</tr>
					<tr>
						<td style="background-color:powderblue;">Date of Resignation : </td>
						<td>' . $field_array["resign_date"] . '</td>
					</tr>
					<tr>
						<td style="background-color:powderblue;">Reason : </td>
						<td>' . $field_array["user_reason"] . '</td>
					</tr>
					<tr>
						<td style="background-color:powderblue;">Remarks : </td>
						<td>' . $field_array["user_remarks"] . '</td>
					</tr>
					<tr>
						<td style="background-color:powderblue;">Requested Relieving Date : </td>
						<td>' . $field_array["released_date"] . '</td>
					</tr>
					<tr>
						<td style="background-color:powderblue;">Date of joining : </td>
						<td>' . $doj . '</td>
					</tr>
					<tr>
						<td style="background-color:powderblue;">Employment status (Permanent/Probationer) : </td>
						<td>Permanent</td>
					</tr>
					</tr>
				</tbody>
			</table><br>';

			//$nbody_hr .="<span>For updating the exit kindly follow the path: <a href='https://fems.fusionbposervices.com/fems/' target='_blank'>https://fems.fusionbposervices.com/fems/</a> - select Resignation.</span></br></br>";

			$nbody_hr .= "<span>For updating the exit kindly follow the path: <a href='https://mindwork.place/fusion/' target='_blank'>https://mindwork.place/fusion/</a> - select Resignation.</span></br></br>";

			$nbody_hr .= "<b>Regards,</b> </br>
			<b>$company_hr</b></br>";

			//for employee
			$this->send_email_sox($uid, $email_id_off, $email_id_per, $nbody, $email_subject, "", $from_email, $from_name,'N',$brand);

			//for hr
			$this->send_email_sox($uid, implode(',', $cc), $l1_email_off, $nbody_hr, $email_subject, "", $from_email, $from_name,'N',$brand);
		}
	}


	//////////////////////////////////////////////////////////////////////
	////////////////////////Resign section email end//////////////////////
	//////////////////////////////////////////////////////////////////////




	public function auto_notify_late_login()
	{

		/*
			$evt_date=strtotime("now");
			 
			$currDate=CurrDate();
			$currDay=strtolower(date('D', strtotime($currDate)));
			
			
			$qSql="Select user_id,b.fusion_id,b.omuid,in_time,out_time from user_shift_schedule a, signin b where a.user_id=b.id and shdate='$currDate' and shday='$currDay' and dept_id='6' and b.role_id in (SELECT id FROM `role` WHERE `folder` in ('agent','supervisor','tl','trainer')) and b.status=1 and b.is_logged_in=0 and b.id not in ( select user_id from (select user_id from event_disposition  where start_date <= '$currDate' and end_date >= '$currDate' UNION select user_id from logged_in_details where cast(login_time as date) >= '$currDate' and cast(login_time as date) <= '$currDate' ) t ) order by b.id";
			
			//echo $qSql . "<br>";
			
				$schRes=$this->db->query($qSql)->result();
				
				foreach($schRes as $row){
					
					$fusion_id=$row->fusion_id;
					$omuid=$row->omuid;
					$user_id=$row->user_id;
					$shIn=$row->in_time;
					$shOut=$row->out_time;
					
					try{
						if(strtoupper($shIn)!="OFF"){
							
							//echo $shIn;
							$log_time_str=$currDate." ".$shIn;
							
							//echo "Sh Time: " . $log_time_str . "   |  ". $evt_date ."<br>";
							
							$log_time = strtotime($log_time_str);
							$interval  = $log_time - $evt_date;							
							$minutes   = round($interval / 60);
							
							if($minutes<= -15){
								
								$qSql="select count(user_id) as value from email_log where user_id ='$user_id' and (cast(send_time as date) = '".$currDate."' and email_for = 'LATELOGIN' and is_send='Y')";
								//echo $qSql ."  = ";
								
								$is_email_send=$this->Common_model->get_single_value($qSql);
								//echo $is_email_send ."<br><br>";
								
								if($is_email_send==0) $this->send_email_late_login($user_id,$currDate,$shIn,$shOut);
								
							}
						} // off if
					
					}catch(Exception $ex){
						log_message('SOX',  'Caught exception: ',  $ex->getMessage());						
					}
					
				} //for
				
		*/
	}


	public function send_email_ncns_agent($uid, $cd_date)
	{

		return false;


		//$qSql="select a.omuid,a.client_id, max(login_time) as llogin_time,max(logout_time) as llogout_time,CONCAT(fname,' ' ,lname) as full_name,(Select name from site z  where z.id=a.site_id) as site_name,(select name from process y where y.id=a.process_id) as process_name from signin a left join `logged_in_details` b on a.id=b.user_id where a.id='$uid'";

		$qSql = "select a.office_id, a.omuid,a.site_id,a.brand,a.client_id, max(login_time) as llogin_time,max(logout_time) as llogout_time,CONCAT(fname,' ' ,lname) as full_name,(Select name from site z  where z.id=a.site_id) as site_name,get_process_names(a.id) as process_name from signin a left join `logged_in_details` b on a.id=b.user_id where a.id='$uid'";

		$query = $this->db->query($qSql);
		$uRow = $query->row_array();

		$omuid = $uRow["omuid"];
		$client_id = $uRow["client_id"];
		$office_id = $uRow["office_id"];

		// $qSql = "select * from notification_info where sch_for='NCNS' and is_active=1 and office_id='$office_id'";

		$full_name = $uRow["full_name"];
		$site_name = $uRow["site_name"];
		$llogin_time = $uRow["llogin_time"];
		$llogout_time = $uRow["llogout_time"];
		$process_name = $uRow["process_name"];
		
		$brand = $uRow["brand"];
		$site_id = $uRow["site_id"];


		$event = 'NCNS';

		$res = get_notification_info($event,$brand,$site_id,$office_id);


		// $query = $this->db->query($qSql);
		if (count($res) > 0) {

			// $res = $query->row_array();

			$ecc = ""; //$res["email_id"];

			$from_email = $res["from_email"];
			$from_name = $res["from_name"];


			//$esubject=$site_name ." - ".$res["email_subject"] ." of ".$full_name." (".$omuid.")";

			$esubject = $site_name . " - " . $process_name . " / " . $res["email_subject"] . " / " . $full_name . " / " . $omuid;

			$ebody = $res["email_body"];

			$nbody = "<br><table width='98%'  cellspacing='2' cellpadding='2' style='border:1px solid #ccc;'>";
			$nbody .= "<tr style='background-color: #FFCC00; text-align:center;'> <td style='padding:5px; border:1px solid #ccc;'>Agent Name</td> <td style='padding:5px; border:1px solid #ccc;'>OM ID</td> <td style='padding:5px; border:1px solid #ccc;'>SITE</td><td style='padding:5px; border:1px solid #ccc;'>Process</td><td style='padding:5px; border:1px solid #ccc;'> Last Logout Time</td></tr>";
			$nbody .= "<tr style='text-align:center;'> <td style='padding:5px; border:1px solid #ccc;'>$full_name</td> <td style='padding:5px; border:1px solid #ccc;'>$omuid</td> <td style='padding:5px; border:1px solid #ccc;'>$site_name</td><td style='padding:5px; border:1px solid #ccc;'>$process_name</td><td style='padding:5px; border:1px solid #ccc;'>$llogout_time</td></tr>";

			$nbody .= "</table>";
			$nbody .= "<p>$ebody</p>";

			$eto = $res["email_id"];//'saikat.ray@omindtech.com,sankha.chowdhury@omindtech.com,sakil.khan@omindtech.com';

			//$qSql="Select email_id as value from signin where id ='$uid'";
			//$eto=$this->Common_model->get_single_value($qSql);

			$this->send_email_sox($uid, $eto, $ecc, $nbody, $esubject, "", $from_email, $from_name);
		}
	}


	public function send_email_ncns($uid, $cd_date)
	{

		return false;


		$qSql = "select count(user_id) as value from terminate_users_pre where user_id ='$uid' and action_status='P'";
		$have_pre_term = $this->Common_model->get_single_value($qSql);

		if ($have_pre_term == 0) {


			$prev_date = date('Y-m-d', strtotime(date($cd_date) . ' -1 day'));

			$qSql = "select start_date,event_master_id from event_disposition where user_id ='$uid' and start_date <= '" . $prev_date . "' order by start_date desc limit 30";

			$allDisp = $this->get_query_result_array($qSql);
			//print_r($allDisp);

			$SendMailNcns = false;
			$lDisp_date = "";

			foreach ($allDisp as $dRow) {

				$lDisp_date = $dRow['start_date'];

				$dis_id = $dRow['event_master_id'];
				if ($dis_id == "2") {
					$SendMailNcns = true;
					break;
				} else if ($dis_id != "5") {
					$SendMailNcns = false;
					break;
				}
			}

			if ($SendMailNcns == true) {
				$qSql = "select count(user_id) as value from logged_in_details where user_id ='$uid' and (cast(login_time as date) >= '" . $lDisp_date . "' and cast(login_time as date) <= '" . $cd_date . "')";

				//echo $qSql ."<br><br>";
				$last_logged_in_cnt = $this->Common_model->get_single_value($qSql);

				if ($last_logged_in_cnt == 0) {

					//$this->load->library('email');

					//$qSql="select a.omuid,a.client_id,max(login_time) as llogin_time,max(logout_time) as llogout_time,CONCAT(fname,' ' ,lname) as full_name,(Select name from site z  where z.id=a.site_id) as site_name,(select name from process y where y.id=a.process_id) as process_name from signin a left join `logged_in_details` b on a.id=b.user_id where a.id='$uid'";

					$qSql = "select a.omuid,a.client_id,max(login_time) as llogin_time,max(logout_time) as llogout_time,CONCAT(fname,' ' ,lname) as full_name,(Select name from site z  where z.id=a.site_id) as site_name,get_process_names(a.id) as process_name,a.brand,a.site_id from signin a left join `logged_in_details` b on a.id=b.user_id where a.id='$uid'";



					$query = $this->db->query($qSql);
					$uRow = $query->row_array();

					$omuid = $uRow["omuid"];
					$client_id = $uRow["client_id"];

					$full_name = $uRow["full_name"];
					$site_name = $uRow["site_name"];
					$llogin_time = $uRow["llogin_time"];
					$llogout_time = $uRow["llogout_time"];

					$process_name = $uRow["process_name"];
				

					$myCDate = CurrMySqlDate();

					//////////////////////////////////////////////////////////

					if ($client_id == 1) {

						$pre_term_array = array(
							"user_id" => $uid,
							"pre_req_date" => $myCDate,
							"last_login_time" => $llogin_time,
							"last_logout_time" => $llogout_time,
							"is_update"	=> 'N',
							"action_status"	=> 'P',
						);
						$this->db->insert("terminate_users_pre", $pre_term_array);
					}

					////////////////////////////////////////////////////////////


					// $qSql = "select * from notification_info where sch_for='2ndNCNS' and is_active=1 and client_id='$client_id'";
					// $query = $this->db->query($qSql);
					// if ($query->num_rows() > 0) {
					$brand = $uRow["brand"];
					$site_id = $uRow["site_id"];

					$event = '2ndNCNS';

					$res = get_notification_info($event,$brand,$site_id,"",$client_id);


					// $query = $this->db->query($qSql);
					if (count($res) > 0) {
						// $res = $query->row_array();
						$eto=$res["email_id"];
						//$eto = 'saikat.ray@omindtech.com,sankha.chowdhury@omindtech.com,sakil.khan@omindtech.com';
						$from_email = $res["from_email"];
						$from_name = $res["from_name"];

						//$esubject=$site_name ." - ".$res["email_subject"] ." of ".$full_name." (".$omuid.")";

						$esubject = $site_name . " - " . $process_name . " / " . $res["email_subject"] . " / " . $full_name . " / " . $omuid;

						$ebody = $res["email_body"];

						$nbody = "<br><table width='98%'  cellspacing='2' cellpadding='2' style='border:1px solid #ccc;'>";
						$nbody .= "<tr style='background-color: #FFCC00; text-align:center;'> <td style='padding:5px; border:1px solid #ccc;'>Agent Name</td> <td style='padding:5px; border:1px solid #ccc;'>OM ID</td> <td style='padding:5px; border:1px solid #ccc;'>SITE</td><td style='padding:5px; border:1px solid #ccc;'>Process</td><td style='padding:5px; border:1px solid #ccc;'> Last Logout Time</td><td style='padding:5px; border:1px solid #ccc;'>Next Shift Date/Time</td><td style='padding:5px; border:1px solid #ccc;'>NCNS Term Date/Time</td></tr>";
						$nbody .= "<tr style='text-align:center;'> <td style='padding:5px; border:1px solid #ccc;'>$full_name</td> <td style='padding:5px; border:1px solid #ccc;'>$omuid</td> <td style='padding:5px; border:1px solid #ccc;'>$site_name</td><td style='padding:5px; border:1px solid #ccc;'>$process_name</td><td style='padding:5px; border:1px solid #ccc;'>$llogout_time</td><td style='padding:5px; border:1px solid #ccc;'>&nbsp;</td><td style='padding:5px; border:1px solid #ccc;'>&nbsp;</td></tr>";
						$nbody .= "</table>";
						$nbody .= "<p>$ebody</p>";

						$ecc = "";

						//$qSql="Select email_id as value from signin where id ='$uid'";
						//$ecc=$this->Common_model->get_single_value($qSql);

						$this->send_email_sox($uid, $eto, $ecc, $nbody, $esubject, "", $from_email, $from_name);
					}
				}
			} else {

				$this->send_email_loa_req($uid, $cd_date);
			}
		} //if

	}




	public function send_email_loa_req($uid, $cd_date)
	{

		return false;


		$prev_date = date('Y-m-d', strtotime(date($cd_date) . ' -4 day'));

		$qSql = "select count(user_id) as value from logged_in_details where user_id ='$uid' and (cast(login_time as date) >= '" . $prev_date . "' and cast(login_time as date) <= '" . $cd_date . "')";
		//echo $qSql ."<br><br>";
		$last_login_in_date = $this->Common_model->get_single_value($qSql);

		$qSql = "select count(user_id) as value from event_disposition where user_id ='$uid' and event_master_id in (4,6) and (start_date >= '" . $prev_date . "' and start_date <= '" . $cd_date . "')";
		//echo $qSql ."<br><br>";
		$li_count = $this->Common_model->get_single_value($qSql);

		$created_date = $this->Common_model->get_single_value("Select cast(created_date as date) as value from signin where id='$uid'");


		if ($last_login_in_date == 0 && $li_count == 0 && $created_date <= $prev_date) {
			//$this->load->library('email');

			//$qSql="select a.omuid,a.client_id,max(login_time) as llogin_time,max(logout_time) as llogout_time,CONCAT(fname,' ' ,lname) as full_name,(Select name from site z  where z.id=a.site_id) as site_name,(select name from process y where y.id=a.process_id) as process_name from signin a left join `logged_in_details` b on a.id=b.user_id where a.id='$uid'";

			$qSql = "select a.office_id,a.brand, a.omuid,a.client_id,max(login_time) as llogin_time,max(logout_time) as llogout_time,CONCAT(fname,' ' ,lname) as full_name,(Select name from site z  where z.id=a.site_id) as site_name,get_process_names(a.id) as process_name,a.brand,a.site_id from signin a left join `logged_in_details` b on a.id=b.user_id where a.id='$uid'";

			$query = $this->db->query($qSql);
			$uRow = $query->row_array();

			$omuid = $uRow["omuid"];
			$client_id = $uRow["client_id"];
			$office_id = $uRow["office_id"];

			$full_name = $uRow["full_name"];
			$site_name = $uRow["site_name"];
			$llogin_time = $uRow["llogin_time"];
			$llogout_time = $uRow["llogout_time"];
			$brand = $uRow["brand"];

			$process_name = $uRow["process_name"];

			// $qSql = "select * from notification_info where sch_for='5DAYOFFLINE' and is_active=1 and office_id='$office_id'";
			// $query = $this->db->query($qSql);

			// if ($query->num_rows() > 0) {
			// 	$res = $query->row_array();
			$brand = $uRow["brand"];
			$site_id = $uRow["site_id"];
			$event = '5DAYOFFLINE';

			$res = get_notification_info($event,$brand,$site_id,$office_id);

			if (count($res) > 0) {
				$eto=$res["email_id"];
				//$eto = 'saikat.ray@omindtech.com,sankha.chowdhury@omindtech.com,sakil.khan@omindtech.com';
				$from_email = $res["from_email"];
				$from_name = $res["from_name"];

				//$esubject=$site_name ." - ".$res["email_subject"] . " of " .$full_name. " (".$omuid.")";

				$esubject = $site_name . " - " . $process_name . " / " . $res["email_subject"] . " / " . $full_name . " / " . $omuid;

				$ebody = $res["email_body"];

				$nbody = "<br><table width='98%'  cellspacing='2' cellpadding='2' style='border:1px solid #ccc;'>";
				$nbody .= "<tr style='background-color: #FFCC00; text-align:center;'> <td style='padding:5px; border:1px solid #ccc;'>Agent Name</td> <td style='padding:5px; border:1px solid #ccc;'>OM ID</td> <td style='padding:5px; border:1px solid #ccc;'>SITE</td><td style='padding:5px; border:1px solid #ccc;'>Process</td><td style='padding:5px; border:1px solid #ccc;'> Last Logout Time</td></tr>";
				$nbody .= "<tr style='text-align:center;'> <td style='padding:5px; border:1px solid #ccc;'>$full_name</td> <td style='padding:5px; border:1px solid #ccc;'>$omuid</td> <td style='padding:5px; border:1px solid #ccc;'>$site_name</td><td style='padding:5px; border:1px solid #ccc;'>$process_name</td><td style='padding:5px; border:1px solid #ccc;'>$llogout_time</td></tr>";
				$nbody .= "</table>";
				$nbody .= "<p>$ebody</p>";

				//echo $nbody ."<br><br>";
				//echo $eto ."<br><br>";
				$ecc = "";

				//$qSql="Select email_id as value from signin where id ='$uid'";
				//$ecc=$this->Common_model->get_single_value($qSql);

				$this->send_email_sox($uid, $eto, $ecc, $nbody, $esubject, "", $from_email, $from_name,"",$brand);
			}
		}
	}

	public function send_email_submit_ticket($uid, $cd_date, $comments)
	{

		$qSql = "select a.office_id, a.fusion_id, a.xpoid,a.omuid,a.client_id, fname, lname, a.assigned_to, max(login_time_local) as llogin_time, max(logout_time_local) as llogout_time, CONCAT(fname,' ' ,lname) as full_name,  get_process_names(a.id) as process_name, (Select email_id_per from info_personal inper where inper.user_id=a.id ) as emp_email_per, (Select email_id_off from info_personal inper where inper.user_id=a.assigned_to ) as l1_email, (select shname from department d where d.id=a.dept_id) as dept_name,a.brand,a.site_id from signin a left join `logged_in_details` b on a.id=b.user_id where a.id='$uid'";

		$query = $this->db->query($qSql);
		$uRow = $query->row_array();

		$omuid = $uRow["omuid"];
		$fusion_id = $uRow["fusion_id"];
		$client_id = $uRow["client_id"];
		$office_id = $uRow["office_id"];

		$full_name = $uRow["full_name"];
		$fname = $uRow["fname"];
		$lname = $uRow["lname"];
		$llogin_time = $uRow["llogin_time"];
		$llogout_time = $uRow["llogout_time"];
		$process_name = $uRow["process_name"];

		$dept_name = $uRow["dept_name"];
		$emp_email_per = $uRow["emp_email_per"];

		$l1_email_off = $uRow["l1_email"];
		$l1_id = $uRow["assigned_to"];

		$qSql = "SELECT email_id_off as value FROM `info_personal` WHERE user_id = (select assigned_to from signin where id='" . $l1_id . "');";
		$l2_email_off = $this->Common_model->get_single_value($qSql);


		// $qSql = "select * from notification_info where sch_for='TERMSUSER' and is_active=1 and office_id='$office_id'";
		// $query = $this->db->query($qSql);
		// if ($query->num_rows() > 0) {

		$brand = $uRow["brand"];
		$site_id = $uRow["site_id"];

		$event = 'TERMSUSER';

		$res = get_notification_info($event,$brand,$site_id,$office_id);

		if (count($res) > 0) {
			// $res = $query->row_array();
			$eto=$res["email_id"];
			//$eto = 'saikat.ray@omindtech.com,sankha.chowdhury@omindtech.com,sakil.khan@omindtech.com';
			$from_email = $res["from_email"];
			$from_name = $res["from_name"];

			$ecc = array();
			$ecc[] = $res["cc_email_id"];

			$ecc[] = $l1_email_off;
			$ecc[] = $l2_email_off;

			//if($office_id!="CEB") $ecc[] = $emp_email_per;

			$cc = array_filter($ecc);

			$newdt = explode(" ", $cd_date);
			$dtOnly = mysql2mmddyy($newdt[0]);

			$esubject = $office_id . " - " . $dept_name . " - " . $process_name . " / " . $res["email_subject"] . " / " . $full_name . " / " . $fusion_id . " / " . $dtOnly;

			$ebody = $res["email_body"];

			$nbody = "<br><table width='98%' cellspacing='2' cellpadding='2' style='border:1px solid #ccc;'>";
			$nbody .= "<tr style='background-color: #FFCC00; text-align:center;'><td style='padding:5px; border:1px solid #ccc;'>Fusion ID</td><td style='padding:5px; border:1px solid #ccc;'>First Name</td> <td style='padding:5px; border:1px solid #ccc;'>Last Name</td> <td style='padding:5px; border:1px solid #ccc;'>Status</td> <td style='padding:5px; border:1px solid #ccc;'>Location</td> <td style='padding:5px; border:1px solid #ccc;'>Process</td><td style='padding:5px; border:1px solid #ccc;'> Last Logout Time</td><td style='padding:5px; border:1px solid #ccc;'>Term Time</td><td style='padding:5px; border:1px solid #ccc;'>Comments</td></tr>";

			$nbody .= "<tr style='text-align:center;'><td style='padding:5px; border:1px solid #ccc;'>$fusion_id</td><td style='padding:5px; border:1px solid #ccc;'>$fname</td> <td style='padding:5px; border:1px solid #ccc;'>$lname</td> <td style='padding:5px; border:1px solid #ccc;'>Term</td> <td style='padding:5px; border:1px solid #ccc;'>$office_id</td><td style='padding:5px; border:1px solid #ccc;'>$process_name</td><td style='padding:5px; border:1px solid #ccc;'>$llogout_time</td><td style='padding:5px; border:1px solid #ccc;'>$cd_date</td><td style='padding:5px; border:1px solid #ccc;'>$comments</td></tr>";
			$nbody .= "</table>";
			$nbody .= "<p>$ebody</p>";

			$this->send_email_sox($uid, $eto, implode(',', $cc), $nbody, $esubject, "", $from_email, $from_name);
		}
	}


	public function send_email_tarms($uid, $ticket_no, $ticket_date, $comments)
	{
		$qSql = "select a.office_id,a.brand,a.site_id, a.fusion_id, a.xpoid,a.omuid,a.client_id, a.assigned_to, max(login_time_local) as llogin_time, max(logout_time_local) as llogout_time, CONCAT(fname,' ' ,lname) as full_name,  get_process_names(a.id) as process_name, (Select email_id_per from info_personal inper where inper.user_id=a.id ) as emp_email_per, (Select email_id_off from info_personal inper where inper.user_id=a.assigned_to ) as l1_email, (select shname from department d where d.id=a.dept_id) as dept_name  from signin a left join `logged_in_details` b on a.id=b.user_id where a.id='$uid'";

		$query = $this->db->query($qSql);
		$uRow = $query->row_array();

		$omuid = $uRow["omuid"];
		$fusion_id = $uRow["fusion_id"];
		$client_id = $uRow["client_id"];
		$office_id = $uRow["office_id"];
		

		$full_name = $uRow["full_name"];

		$llogin_time = $uRow["llogin_time"];
		$llogout_time = $uRow["llogout_time"];

		$process_name = $uRow["process_name"];
		$dept_name = $uRow["dept_name"];
		$emp_email_per = $uRow["emp_email_per"];

		$l1_email_off = $uRow["l1_email"];
		$l1_id = $uRow["assigned_to"];

		$qSql = "SELECT email_id_off as value FROM `info_personal` WHERE user_id = (select assigned_to from signin where id='" . $l1_id . "');";
		$l2_email_off = $this->Common_model->get_single_value($qSql);

		if ($comments == "") {
			$qSql1 = "Select comments as value from terminate_users where user_id='$uid' order by id desc limit 1";
			$comments = $this->Common_model->get_single_value($qSql1);
		}

		$brand=$uRow['brand'];
		$site_id=$uRow['site_id'];

		// $qSql = "select * from notification_info where sch_for='TREMRTICKET' and is_active=1 and office_id='$office_id'";
		// $query = $this->db->query($qSql);
		// if ($query->num_rows() > 0) {
		// 	$res = $query->row_array();
		$event = 'TREMRTICKET';

		$res = get_notification_info($event,$brand,$site_id,$office_location);

		if (count($res) > 0) {
			$eto=$res["email_id"];
			//$eto = 'saikat.ray@omindtech.com,sankha.chowdhury@omindtech.com,sakil.khan@omindtech.com';
			$from_email = $res["from_email"];
			$from_name = $res["from_name"];

			$ecc = array();
			$ecc[] = $res["cc_email_id"];
			$ecc[] = $l1_email_off;
			$ecc[] = $l2_email_off;

			//if($office_id!="CEB") $ecc[] = $emp_email_per;

			$cc = array_filter($ecc);

			$esubject = $office_id . " - " . $dept_name . " - " . $process_name . " / " . $res["email_subject"] . " / " . $full_name . " / " . $fusion_id;

			$ebody = $res["email_body"];

			$nbody = "<br><table width='98%' cellspacing='2' cellpadding='2' style='border:1px solid #ccc;'>";
			$nbody .= "<tr style='background-color: #FFCC00; text-align:center;'><td style='padding:5px; border:1px solid #ccc;'>Name</td> <td style='padding:5px; border:1px solid #ccc;'>Fusion ID</td> <td style='padding:5px; border:1px solid #ccc;'>Location</td> <td style='padding:5px; border:1px solid #ccc;'>Department</td> <td style='padding:5px; border:1px solid #ccc;'>Process</td><td style='padding:5px; border:1px solid #ccc;'>Ticket No</td><td style='padding:5px; border:1px solid #ccc;'>Ticket Date</td><td style='padding:5px; border:1px solid #ccc;'>Comments</td><td style='padding:5px; border:1px solid #ccc;'> Last Logout Time</td></tr>";

			$nbody .= "<tr style='text-align:center;'><td style='padding:5px; border:1px solid #ccc;'>$full_name</td> <td style='padding:5px; border:1px solid #ccc;'>$fusion_id</td> <td style='padding:5px; border:1px solid #ccc;'>$office_id</td> <td style='padding:5px; border:1px solid #ccc;'>$dept_name</td> <td style='padding:5px; border:1px solid #ccc;'>$process_name</td><td style='padding:5px; border:1px solid #ccc;'>$ticket_no</td><td style='padding:5px; border:1px solid #ccc;'>$ticket_date</td><td style='padding:5px; border:1px solid #ccc;'>$comments</td><td style='padding:5px; border:1px solid #ccc;'>$llogout_time</td></tr>";
			$nbody .= "</table>";
			$nbody .= "<p>$ebody</p>";

			//echo $nbody ."<br><br>";
			//echo $eto ."<br><br>";

			$this->send_email_sox($uid, $eto, implode(',', $cc), $nbody, $esubject, "", $from_email, $from_name,"",$brand);
		}
	}


	public function send_email_tarms_pre($uid, $pre_id)
	{

		return false;

		$this->load->library('email');

		//$qSql="select b.*,a.omuid,a.client_id,CONCAT(fname,' ' ,lname) as full_name,(Select name from site z  where z.id=a.site_id) as site_name,(select name from process y where y.id=a.process_id) as process_name from signin a left join `terminate_users_pre` b on a.id=b.user_id where a.id='$uid' and b.id='$pre_id' and action_status='P'";

		$qSql = "select b.*,a.brand,a.site_id, a.office_id, a.omuid,a.client_id,CONCAT(fname,' ' ,lname) as full_name,(Select name from site z  where z.id=a.site_id) as site_name,get_process_names(a.id) as process_name from signin a left join `terminate_users_pre` b on a.id=b.user_id where a.id='$uid' and b.id='$pre_id' and action_status='P'";


		$query = $this->db->query($qSql);
		$uRow = $query->row_array();

		$omuid = $uRow["omuid"];
		$client_id = $uRow["client_id"];
		$office_id = $uRow["office_id"];

		$full_name = $uRow["full_name"];
		$site_name = $uRow["site_name"];
		$llogin_time = $uRow["last_login_time"];
		$llogout_time = $uRow["last_logout_time"];
		
		$process_name = $uRow["process_name"];
		$next_shift_time = $uRow["next_shift_time"];
		$term_time = $uRow["term_time"];

		$newdt = explode(" ", $term_time);
		$dtOnly = mysql2mmddyy($newdt[0]);

		$brand=$uRow['brand'];
		$site_id=$uRow['site_id'];

		// $qSql = "select * from notification_info where sch_for='TERMSUSERPRE' and is_active=1 and office_id='$office_id'";

		// $query = $this->db->query($qSql);
		// if ($query->num_rows() > 0) {
		// 	$res = $query->row_array();
		$event = 'TERMSUSERPRE';

		$res = get_notification_info($event,$brand,$site_id,$office_id);

		if (count($res) > 0) {
			$eto=$res["email_id"];
			//$eto = 'saikat.ray@omindtech.com,sankha.chowdhury@omindtech.com,sakil.khan@omindtech.com';
			$from_email = $res["from_email"];
			$from_name = $res["from_name"];

			//$ecc=$res["cc"];
			//$esubject=$site_name ." - ".$res["email_subject"] . " of " .$full_name. " (".$omuid.")";

			$esubject = $site_name . " - " . $process_name . " / " . $res["email_subject"] . " / " . $full_name . " / " . $dtOnly;

			$ebody = $res["email_body"];

			$nbody = "<br><table width='98%'  cellspacing='2' cellpadding='2' style='border:1px solid #ccc;'>";
			$nbody .= "<tr style='background-color: #FFCC00; text-align:center;'> <td style='padding:5px; border:1px solid #ccc;'>Agent Name</td> <td style='padding:5px; border:1px solid #ccc;'>OM ID</td> <td style='padding:5px; border:1px solid #ccc;'>SITE</td><td style='padding:5px; border:1px solid #ccc;'>Process</td><td style='padding:5px; border:1px solid #ccc;'> Last Logout Time</td><td style='padding:5px; border:1px solid #ccc;'>Next Shift Date/Time</td><td style='padding:5px; border:1px solid #ccc;'>NCNS Term Date/Time</td></tr>";
			$nbody .= "<tr style='text-align:center;'> <td style='padding:5px; border:1px solid #ccc;'>$full_name</td> <td style='padding:5px; border:1px solid #ccc;'>$omuid</td> <td style='padding:5px; border:1px solid #ccc;'>$site_name</td><td style='padding:5px; border:1px solid #ccc;'>$process_name</td><td style='padding:5px; border:1px solid #ccc;'>$llogout_time</td><td style='padding:5px; border:1px solid #ccc;'>$next_shift_time</td><td style='padding:5px; border:1px solid #ccc;'>$term_time</td></tr>";
			$nbody .= "</table>";

			$nbody .= "<p>$ebody</p>";

			//echo $nbody ."<br><br>";
			//echo $eto ."<br><br>";

			$ecc = "";
			/*
				$qSql="Select email_id as value from signin where id ='$uid'";
				$ecc=$this->Common_model->get_single_value($qSql);
				*/

			$this->send_email_sox($uid, $eto, $ecc, $nbody, $esubject, "", $from_email, $from_name,"",$brand);
		}
	}



	public function send_email_reject_pre_tarms($uid, $pre_id, $edesc, $esubject)
	{

		return false;


		//$eto="fusion.sox@fusionbposervices.com, arshad.rahman@fusionbposervices.com";

		$eto = 'saikat.ray@omindtech.com,sankha.chowdhury@omindtech.com,sakil.khan@omindtech.com';
		$ecc = "";
		$nbody = "";

		//$qSql="select b.*,a.omuid,CONCAT(fname,' ' ,lname) as full_name,(Select name from site z  where z.id=a.site_id) as site_name,(select name from process y where y.id=a.process_id) as process_name from signin a left join `terminate_users_pre` b on a.id=b.user_id where a.id='$uid' and b.id='$pre_id'";

		$qSql = "select b.*,a.brand,a.site_id,a.office_id, a.omuid,CONCAT(fname,' ' ,lname) as full_name,(Select name from site z  where z.id=a.site_id) as site_name,get_process_names(a.id) as process_name from signin a left join `terminate_users_pre` b on a.id=b.user_id where a.id='$uid' and b.id='$pre_id'";

		$query = $this->db->query($qSql);
		$uRow = $query->row_array();

		$omuid = $uRow["omuid"];
		$client_id = $uRow["client_id"];
		$office_id = $uRow["office_id"];

		$full_name = $uRow["full_name"];
		$site_name = $uRow["site_name"];
		$llogin_time = $uRow["last_login_time"];
		$llogout_time = $uRow["last_logout_time"];
		

		$process_name = $uRow["process_name"];
		$next_shift_time = $uRow["next_shift_time"];
		$term_time = $uRow["term_time"];



		$brand=$uRow['brand'];
		$site_id=$uRow['site_id'];
		// $qSql = "select * from notification_info where sch_for='REJECTPRETERM' and is_active=1 and office_id='$office_id'";

		// $query = $this->db->query($qSql);
		// if ($query->num_rows() > 0) {
		// 	$res = $query->row_array();

		$event = 'REJECTPRETERM';

		$res = get_notification_info($event,$brand,$site_id,$office_location);

		if (count($res) > 0) {
			//$eto=$res["email_id"];

			$from_email = $res["from_email"];
			$from_name = $res["from_name"];

			$nbody = "<br><table width='98%'  cellspacing='2' cellpadding='2' style='border:1px solid #ccc;'>";
			$nbody .= "<tr style='background-color: #FFCC00; text-align:center;'> <td style='padding:5px; border:1px solid #ccc;'>Agent Name</td> <td style='padding:5px; border:1px solid #ccc;'>OM ID</td> <td style='padding:5px; border:1px solid #ccc;'>SITE</td><td style='padding:5px; border:1px solid #ccc;'>Process</td><td style='padding:5px; border:1px solid #ccc;'> Last Logout Time</td><td style='padding:5px; border:1px solid #ccc;'>Next Shift Date/Time</td><td style='padding:5px; border:1px solid #ccc;'>NCNS Term Date/Time</td></tr>";

			$nbody .= "<tr style='text-align:center;'> <td style='padding:5px; border:1px solid #ccc;'>$full_name</td> <td style='padding:5px; border:1px solid #ccc;'>$omuid</td> <td style='padding:5px; border:1px solid #ccc;'>$site_name</td><td style='padding:5px; border:1px solid #ccc;'>$process_name</td><td style='padding:5px; border:1px solid #ccc;'>$llogout_time</td><td style='padding:5px; border:1px solid #ccc;'>$next_shift_time</td><td style='padding:5px; border:1px solid #ccc;'>$term_time</td></tr>";
			$nbody .= "</table>";

			$nbody .= "<p>$edesc</p>";

			//$esubject = $site_name ." - ". $esubject;

			$esubject = $site_name . " - " . $process_name . " / " . $esubject . " / " . $full_name . " / " . $omuid;

			$this->send_email_sox($uid, $eto, $ecc, $nbody, $esubject, "", $from_email, $from_name,"",$brand);
		}
	}


	public function send_fnf_email($uid, $fnf_type, $lwd)
	{


		$qSql = "select a.office_id, a.fusion_id,a.brand,a.site_id,a.xpoid,a.omuid,assigned_to,CONCAT(fname,' ' ,lname) as full_name, (select shname from department d where d.id=a.dept_id) as dept_name, (Select name from site z  where z.id=a.site_id) as site_name, get_process_names(a.id) as process_name, get_client_names(a.id) as client_name, ip.email_id_off as l1_email_off, (Select CONCAT(fname,' ' ,lname) from signin x where x.id=a.assigned_to) as asign_l1 from signin a left join info_personal as ip on ip.user_id=a.assigned_to where a.id='$uid'";

		$query = $this->db->query($qSql);
		$uRow = $query->row_array();

		$xpoid = $uRow["xpoid"];
		$fusion_id = $uRow["fusion_id"];
		
		$office_id = $uRow["office_id"];
		$full_name = $uRow["full_name"];
		$dept_name = $uRow["dept_name"];
		$process_name = $uRow["process_name"];
		$client_name = $uRow["client_name"];

		$asign_l1 = $uRow["asign_l1"];
		$l1_email_off = $uRow["l1_email_off"];
		$l1_id = $uRow["assigned_to"];

		$qSql = "SELECT email_id_off as value FROM `info_personal` WHERE user_id = (select assigned_to from signin where id='" . $l1_id . "');";
		$l2_email_off = $this->Common_model->get_single_value($qSql);

		$fnf_msg = " is in notice period ";
		if ($fnf_type == "term") 	$fnf_msg = " terminated ";

		$ebody = "<br/>Dear All, <br/><br/>This is to notify you that below mentioned employee " . $fnf_msg . " from the service and his Last Working Day is " . $lwd . ". Kindly fill the FNF form in MWP, to complete the exit process.";

		$brand=$uRow['brand'];
		$site_id=$uRow['site_id'];

		// $qSql = "select * from notification_info where sch_for='TERM_FNF' and is_active=1 and office_id='$office_id'";
		// $query = $this->db->query($qSql);
		// if ($query->num_rows() > 0) {
			
		// 	$res = $query->row_array();
		$event = 'TERM_FNF';

		$res = get_notification_info($event,$brand,$site_id,$office_id);

		if (count($res) > 0) {

			$eto= $res["email_id"] .", ". $l1_email_off .", ". $l2_email_off;
			
			$ecc = $res["cc_email_id"];

			$esubject = $res["email_subject"] . " / " . $full_name . " / " . $fusion_id . " / " . $office_id . " / " . $dept_name;

			$html = '<br/><br/>';
			$html .= '<table style="border-collapse: collapse; border:1px solid #000000">';
			$html .= '<tr>';
			$html .= '<td style="background-color:#eeeeee; font-weight:bold; border:1px solid #000000; padding:5px 10px;">Fusion ID</td>';
			$html .= '<td style="border:1px solid #000000; padding:5px 10px;">' . $fusion_id . '</td>';
			$html .= '</tr>';

			$html .= '<tr>';
			$html .= '<td style="background-color:#eeeeee; font-weight:bold; border:1px solid #000000; padding:5px 10px;">Name</td>';
			$html .= '<td style="border:1px solid #000000; padding:5px 10px;">' . $full_name . '</td>';
			$html .= '</tr>';

			$html .= '<tr>';
			$html .= '<td style="background-color:#eeeeee; font-weight:bold; border:1px solid #000000; padding:5px 10px;">Last Working Day</td>';
			$html .= '<td style="border:1px solid #000000; padding:5px 10px;">' . $lwd . '</td>';
			$html .= '</tr>';

			$html .= '<tr>';
			$html .= '<td style="background-color:#eeeeee; font-weight:bold; border:1px solid #000000; padding:5px 10px;">Reporting Head</td>';
			$html .= '<td style="border:1px solid #000000; padding:5px 10px;">' . $asign_l1 . '</td>';
			$html .= '</tr>';

			$html .= '<tr>';
			$html .= '<td style="background-color:#eeeeee; font-weight:bold; border:1px solid #000000; padding:5px 10px;">Department</td>';
			$html .= '<td style="border:1px solid #000000; padding:5px 10px;">' . $dept_name . '</td>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<td style="background-color:#eeeeee; font-weight:bold; border:1px solid #000000; padding:5px 10px;">Client</td>';
			$html .= '<td style="border:1px solid #000000; padding:5px 10px;">' . $client_name . '</td>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<td style="background-color:#eeeeee; font-weight:bold; border:1px solid #000000; padding:5px 10px;">Process Date</td>';
			$html .= '<td style="border:1px solid #000000; padding:5px 10px;">' . $process_name . '</td>';
			$html .= '</tr>';
			$html .= '</table>';

			$nbody = $ebody . "<br>" . $html;


			$this->send_email_sox($uid, $eto, $ecc, $nbody, $esubject,"","","","N",$brand);
		}
	}

	//
	// LEAVE APPLY MAIL
	//

	public function leave_apply_emails($_user_id, $_leave_id)
	{
		
		// email_id_off, email_id_per

		$_user_query = $this->db->query("select concat(S.fname,' ',S.lname) as user, 
						S.fusion_id, S.assigned_to, ip.email_id_off as email_id_off_emp, concat(SA.fname,' ',SA.lname) as reporting_head, ipas.email_id_off as reporting_email, D.description as department, LT.description as leave_type, LA.from_dt, LA.to_dt, LA.reason, LA.contact_details, LA.apply_date
						from signin S 
						LEFT join leave_applied LA on S.id = LA.user_id 
						LEFT join department D on S.dept_id = D.id 
						LEFT join signin SA on SA.id = S.assigned_to
						LEFT JOIN info_personal AS ip ON ip.user_id=S.id 
						LEFT JOIN info_personal AS ipas ON ipas.user_id=S.assigned_to 
						LEFT join office_location OL on S.office_id = OL.abbr
						LEFT join leave_type LT on LA.leave_type_id = LT.id
						where LA.id =" . $_leave_id);

		$_res = $_user_query->row();

		$html = '<p>***This is an auto generated email, please do not reply.</p><br/><br/>';
		$html .= '<p><strong>Leave Application Request</strong></p><br/><br/>';
		$html .= '<table style="border-collapse: collapse; border:1px solid #000000">';
		$html .= '<tr>';
		$html .= '<td style="background-color:#eeeeee; font-weight:bold; border:1px solid #000000; padding:5px 10px;">Fusion ID</td>';
		$html .= '<td style="border:1px solid #000000; padding:5px 10px;">' . $_res->fusion_id . '</td>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<td style="background-color:#eeeeee; font-weight:bold; border:1px solid #000000; padding:5px 10px;">Name</td>';
		$html .= '<td style="border:1px solid #000000; padding:5px 10px;">' . $_res->user . '</td>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<td style="background-color:#eeeeee; font-weight:bold; border:1px solid #000000; padding:5px 10px;">Reporting Head</td>';
		$html .= '<td style="border:1px solid #000000; padding:5px 10px;">' . $_res->reporting_head . '</td>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<td style="background-color:#eeeeee; font-weight:bold; border:1px solid #000000; padding:5px 10px;">Department</td>';
		$html .= '<td style="border:1px solid #000000; padding:5px 10px;">' . $_res->department . '</td>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<td style="background-color:#eeeeee; font-weight:bold; border:1px solid #000000; padding:5px 10px;">Leave Type</td>';
		$html .= '<td style="border:1px solid #000000; padding:5px 10px;">' . $_res->leave_type . '</td>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<td style="background-color:#eeeeee; font-weight:bold; border:1px solid #000000; padding:5px 10px;">From Date</td>';
		$html .= '<td style="border:1px solid #000000; padding:5px 10px;">' . $_res->from_dt . '</td>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<td style="background-color:#eeeeee; font-weight:bold; border:1px solid #000000; padding:5px 10px;">To Date</td>';
		$html .= '<td style="border:1px solid #000000; padding:5px 10px;">' . $_res->to_dt . '</td>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<td style="background-color:#eeeeee; font-weight:bold; border:1px solid #000000; padding:5px 10px;">Reason</td>';
		$html .= '<td style="border:1px solid #000000; padding:5px 10px;">' . $_res->reason . '</td>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<td style="background-color:#eeeeee; font-weight:bold; border:1px solid #000000; padding:5px 10px;">Contact Details</td>';
		$html .= '<td style="border:1px solid #000000; padding:5px 10px;">' . $_res->contact_details . '</td>';
		$html .= '</tr>';
		$html .= '</table>';

		$ecc = $_res->email_id_off_emp;
		$subject = $_res->leave_type . " Request";
		$eto = $_res->reporting_email;
		$this->send_email_sox($_user_id, $eto, $ecc, $html, $subject);
	}

	//
	//
	//
	public function self_leave_approval_emails($_user_id, $_leave_id)
	{
				

		$_user_query = $this->db->query("select concat(S.fname,' ',S.lname) as user, 
						S.fusion_id, S.assigned_to, ip.email_id_off as email_id_off_emp, concat(SA.fname,' ',SA.lname) as reporting_head, 
						ipas.email_id_off as reporting_email, D.description as department, LT.description as leave_type,
						LA.from_dt, LA.to_dt, LA.reason, LA.contact_details, LA.apply_date
						from signin S 
						inner join leave_applied LA on S.id = LA.user_id 
						inner join department D on S.dept_id = D.id 
						inner join signin SA on SA.id = S.assigned_to
						LEFT JOIN info_personal AS ip ON ip.user_id=S.id 
						LEFT JOIN info_personal AS ipas ON ipas.user_id=S.assigned_to 
						inner join office_location OL on S.office_id = OL.abbr
						inner join leave_type LT on LA.leave_type_id = LT.id
						where LA.id =" . $_leave_id);

		$_res = $_user_query->row();

		$html = '<p>***This is an auto generated email, please do not reply.</p><br/><br/>';
		$html .= '<p><strong>Leave Application Request Approved</strong></p><br/><br/>';
		$html .= '<table style="border-collapse: collapse; border:1px solid #000000">';
		$html .= '<tr>';
		$html .= '<td style="background-color:#eeeeee; font-weight:bold; border:1px solid #000000; padding:5px 10px;">Fusion ID</td>';
		$html .= '<td style="border:1px solid #000000; padding:5px 10px;">' . $_res->fusion_id . '</td>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<td style="background-color:#eeeeee; font-weight:bold; border:1px solid #000000; padding:5px 10px;">Name</td>';
		$html .= '<td style="border:1px solid #000000; padding:5px 10px;">' . $_res->user . '</td>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<td style="background-color:#eeeeee; font-weight:bold; border:1px solid #000000; padding:5px 10px;">Reporting Head</td>';
		$html .= '<td style="border:1px solid #000000; padding:5px 10px;">' . $_res->reporting_head . '</td>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<td style="background-color:#eeeeee; font-weight:bold; border:1px solid #000000; padding:5px 10px;">Department</td>';
		$html .= '<td style="border:1px solid #000000; padding:5px 10px;">' . $_res->department . '</td>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<td style="background-color:#eeeeee; font-weight:bold; border:1px solid #000000; padding:5px 10px;">Leave Type</td>';
		$html .= '<td style="border:1px solid #000000; padding:5px 10px;">' . $_res->leave_type . '</td>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<td style="background-color:#eeeeee; font-weight:bold; border:1px solid #000000; padding:5px 10px;">From Date</td>';
		$html .= '<td style="border:1px solid #000000; padding:5px 10px;">' . $_res->from_dt . '</td>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<td style="background-color:#eeeeee; font-weight:bold; border:1px solid #000000; padding:5px 10px;">To Date</td>';
		$html .= '<td style="border:1px solid #000000; padding:5px 10px;">' . $_res->to_dt . '</td>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<td style="background-color:#eeeeee; font-weight:bold; border:1px solid #000000; padding:5px 10px;">Reason</td>';
		$html .= '<td style="border:1px solid #000000; padding:5px 10px;">' . $_res->reason . '</td>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<td style="background-color:#eeeeee; font-weight:bold; border:1px solid #000000; padding:5px 10px;">Contact Details</td>';
		$html .= '<td style="border:1px solid #000000; padding:5px 10px;">' . $_res->contact_details . '</td>';
		$html .= '</tr>';
		$html .= '</table>';

		$ecc = "";
		$subject = $_res->leave_type . " Approval Mail";
		
		$eto= $_res->reporting_email;
		$ecc = $_res->email_id_off_emp;
		
		$this->send_email_sox($_user_id, $eto, $ecc, $html, $subject);
	}

	public function send_email_restruc_letter($current_user, $uid, $c_name, $email_id_per, $offer_letter)
	{

		$eto = "";
		$ecc = array();
		$nbody = "";

		$cc = "employee.connect@fusionbposervices.com";
		$eto = $email_id_per;
		//$eto = 'saikat.ray@omindtech.com,sankha.chowdhury@omindtech.com,sakil.khan@omindtech.com';
		$email_subject = "Post 2020 - Lockdown New Salary Structure.";

		$from_email = "noreply.fems@fusionbposervices.com";
		$from_name = "Fusion FEMS";


		$nbody = '
					Dear <b>' . $c_name . '</b></br></br>
						Please find your post lockdown new salary structure.		
						
						</br>
						</br>
						</br>
						
					Regards, </br>
					Fusion - Global HR Shared Services	</br>

				';


		$this->send_email_sox($uid, $eto, $cc, $nbody, $email_subject, $offer_letter, $from_email, $from_name);
	}


	public function resend_email_offer_letter($current_user, $uid, $c_name, $email_id_per, $offer_letter)
	{
		$eto = "";
		$ecc = array();
		$nbody = "";

		$event = 'DFR-Candidate Selected';

		$res = get_notification_info($event,"","","","","");

		$from_email = "";
		$from_name = "";
		$ecc_str = ""; //"employee.connect@fusionbposervices.com";

		if(count($res)>0){
			$from_email = $res["from_email"];
			$from_name = $res["from_name"];
			$company_hr = $res["signature_text"];
			$ecc_str .= "," . $res['cc_email_id'];
		}


		$eto = $email_id_per;
		//$eto = 'saikat.ray@omindtech.com,sankha.chowdhury@omindtech.com,sakil.khan@omindtech.com';
		$email_subject = "offer letter" . ' - ' . $c_name;
		// $from_email = "noreply.fems@fusionbposervices.com";
		// $from_name = "Fusion FEMS";

		$nbody = '
					Dear <b>' . $c_name . '</b></br></br>
						Please find your new offer letter.		
						
						</br>
						</br>
						</br>
						
					Regards, </br>
					'.$company_hr.'	</br>
				';
		$this->send_email_sox($uid, $eto, $ecc_str, $nbody, $email_subject, $offer_letter, $from_email, $from_name);
	}


	public function send_email_sox($uid, $eto, $ecc, $ebody, $esubject, $attch_file = "", $from_email = "noreply.mwp@fusionbposervices.com", $from_name = "Fusion MWP", $isBcc = "Y", $brand = '')
	{

		$ebody .= "<br/><br/><p style='font-size:9px'>Note: please do not reply.</p>";
		//$ebody .="<br/><br/><p style='font-size:9px'>Note: This is an automated system email, please do not reply.</p>";

		
		if($brand==""){
			
			$brand=get_brand_for_email($eto);
		}
		
		//echo'<br>'.$eto.$brand;die();
		if ($brand == '3') {
			$from_email = "noreply.mwp@omindtech.com";
			$from_name = "Omind MWP";
			//$ecc='souvik.mondal@omindtech.com';
		} else {
			$from_email = "noreply.mwp@fusionbposervices.com";
		}
		


		

		//Open it for testing
		$esubject = " TEST - " . $esubject;


		$eto = str_replace(';', ',', $eto);
		$ecc = str_replace(';', ',', $ecc);

		//Open it for testing and add your email id

		//$eto = 'saikat.ray@omindtech.com,souvik.mondal@omindtech.com,Saikat.Naskar@fusionbposervices.com,sk.nurujjaman@omindtech.com,sankha.chowdhury@omindtech.com,daljeet.singh@fusionbposervices.com,sakil.khan@omindtech.com';
		$eto = 'sankha.chowdhury@omindtech.com,sakil.khan@omindtech.com,sanju.malik@omindtech.com,amit.debnath@omindtech.com,rajib.lama@omindtech.com,goutam.paul@omindtech.com,hriday.debnath@omindtech.com,shilpa.mazumder@omindtech.com,deb.dasgupta@omindtech.com,sanchari.de@omindtech.com,pushpita.bakshi@omindtech.com,firoz.ansari@omindtech.com,prachitosh.nayak@omindtech.com,shambhabi.chandra@omindtech.com,anjali.thakur@omindtech.com';
		
		//$eto = 'shilpa.mazumder@omindtech.com';  
		 $ecc = "";
		////////////////////////////

		//$eto='souvik.mondal@omindtech.com';
		$this->load->library('email');
			$fusion_id=get_user_fusion_id();
			$dt=get_mail_config($brand);
			$config['smtp_user']=$dt['email'];
			$config['smtp_pass'] = $dt['password'];
			$this->email->initialize($config); 
			
		$this->email->clear(TRUE);
		
		//echo'<br>'.$brand;
		

		$this->email->set_newline("\r\n");
		$this->email->from($from_email, $from_name);

		$this->email->to($eto);

		if ($ecc != "") $this->email->cc($ecc);

		//$this->email->bcc('kunal.bose@fusionbposervices.com, saikat.ray@fusionbposervices.com, manash.kundu@fusionbposervices.com, arif.anam@fusionbposervices.com');

		if ($isBcc == "Y") $this->email->bcc('saikat.ray@omindtech.com');

		$this->email->subject($esubject);
		$this->email->message($ebody); 

		if ($attch_file != "") $this->email->attach($attch_file);

		//-----------------------------------//
		$ebody = addslashes($ebody);
		$eto = addslashes($eto);
		$esubj = addslashes($esubject);

		$myCDate = CurrMySqlDate();

		$_insert_array = array(
			"email_to" => $eto,
			"subj" => $esubj,
			"body" => $ebody,
			"send_time"	=> $myCDate,
		);

		if ($uid != "") $_insert_array['user_id'] = $uid;
		if ($ecc != "") $_insert_array['email_cc'] = $ecc;
		if ($attch_file != "") $_insert_array['attach_file'] = $attch_file;

		$_table = "email_log";
		//-----------------------------------//
		//echo "<br>".$attch_file;
		//echo "<br>".$eto;
		// echo "<pre>";
		// print_r($this->email);
		// exit;

		if ($eto != "") {
			if ($this->email->send()) {
				$_insert_array['is_send'] = "Y";
				$this->db->insert($_table, $_insert_array);
				return true;
				//echo 'Email sent.';
			} else {				
				$log = addslashes($this->email->print_debugger());
				$_insert_array['log'] = $log;
				$_insert_array['is_send'] = "N";
				$this->db->insert($_table, $_insert_array);
				return false;
				//show_error($this->email->print_debugger());
			}
		}
	}
	public function send_email_diy($uid, $eto, $ecc, $ebody, $esubject, $attch_file = "", $from_email = "noreply.mwp@fusionbposervices.com", $from_name = "DIY - Global HR", $isBcc = "Y")
	{

		$ebody .= "<br/><br/><p style='font-size:9px'>Note: please do not reply.</p>";
		//$ebody .="<br/><br/><p style='font-size:9px'>Note: This is an automated system email, please do not reply.</p>";

		if (trim($from_email) == "") $from_email = "noreply.mwp@fusionbposervices.com";
		if (trim($from_name) == "") $from_name = "DIY - Global HR";

		//Open it for testing
		$esubject = " TEST - " . $esubject;


		$eto = str_replace(';', ',', $eto);
		$ecc = str_replace(';', ',', $ecc);

		//Open it for testing and add your email id
		//$eto = 'saikat.ray@omindtech.com,souvik.mondal@omindtech.com,Saikat.Naskar@fusionbposervices.com,sk.nurujjaman@omindtech.com,sankha.chowdhury@omindtech.com,daljeet.singh@fusionbposervices.com,sakil.khan@omindtech.com';
		$eto = 'sankha.chowdhury@omindtech.com,sakil.khan@omindtech.com,rahul.kumar@omindtech.com,sanju.malik@omindtech.com,amit.debnath@omindtech.com,rajib.lama@omindtech.com,goutam.paul@omindtech.com,hriday.debnath@omindtech.com, shilpa.mazumder@omindtech.com,deb.dasgupta@omindtech.com';
		
		$ecc = "";
		////////////////////////////

		//$eto='souvik.mondal@omindtech.com';
		$this->load->library('email');
		$this->email->clear(TRUE);

		$this->email->set_newline("\r\n");
		$this->email->from($from_email, $from_name);

		$this->email->to($eto);

		if ($ecc != "") $this->email->cc($ecc);

		//$this->email->bcc('kunal.bose@fusionbposervices.com, saikat.ray@fusionbposervices.com, manash.kundu@fusionbposervices.com, arif.anam@fusionbposervices.com');

		if ($isBcc == "Y") $this->email->bcc('saikat.ray@omindtech.com');

		$this->email->subject($esubject);
		$this->email->message($ebody);

		if ($attch_file != "") $this->email->attach($attch_file);

		//-----------------------------------//
		$ebody = addslashes($ebody);
		$eto = addslashes($eto);
		$esubj = addslashes($esubject);

		$myCDate = CurrMySqlDate();

		$_insert_array = array(
			"email_to" => $eto,
			"subj" => $esubj,
			"body" => $ebody,
			"send_time"	=> $myCDate,
		);

		if ($uid != "") $_insert_array['user_id'] = $uid;
		if ($ecc != "") $_insert_array['email_cc'] = $ecc;
		if ($attch_file != "") $_insert_array['attach_file'] = $attch_file;

		$_table = "email_log";
		//-----------------------------------//
		//echo "<br>".$attch_file;
		//echo "<br>".$eto;

		if ($eto != "") {
			if ($this->email->send()) {
				$_insert_array['is_send'] = "Y";
				$this->db->insert($_table, $_insert_array);
				return true;
				//echo 'Email sent.';
			} else {
				$log = addslashes($this->email->print_debugger());
				$_insert_array['log'] = $log;
				$_insert_array['is_send'] = "N";
				$this->db->insert($_table, $_insert_array);
				return false;
				//show_error($this->email->print_debugger());
			}
		}
	}
	public function send_email_sox_multi($uid = '', $eto, $ecc, $ebody, $esubject, $attch_file = "", $from_email = "noreply.mwp@fusionbposervices.com", $from_name = "Fusion FEMS", $isBcc = "Y")
	{

		$ebody .= "<br/><br/><p style='font-size:9px'>Note: please do not reply.</p>";
		//$ebody .="<br/><br/><p style='font-size:9px'>Note: This is an automated system email, please do not reply.</p>";

		if (trim($from_email) == "") $from_email = "noreply.mwp@fusionbposervices.com";
		if (trim($from_name) == "") $from_name = "Fusion FEMS";

		//Open it for testing
		$esubject = " TEST - " . $esubject;

		$eto = str_replace(';', ',', $eto);
		$ecc = str_replace(';', ',', $ecc);

		//Open it for testing and add your email id
		//$eto = 'saikat.ray@omindtech.com,souvik.mondal@omindtech.com,Saikat.Naskar@fusionbposervices.com,sk.nurujjaman@omindtech.com,sankha.chowdhury@omindtech.com,daljeet.singh@fusionbposervices.com,sakil.khan@omindtech.com';
		$eto = 'sankha.chowdhury@omindtech.com,sakil.khan@omindtech.com';
		$ecc = "";
		/////////////////////

		$this->load->library('email');
		$this->email->clear(TRUE);

		$this->email->set_newline("\r\n");
		$this->email->from($from_email, $from_name);

		$this->email->to($eto);

		if ($ecc != "") $this->email->cc($ecc);


		// open after testing 
		if ($isBcc == "Y") $this->email->bcc('saikat.ray@omindtech.com');


		$this->email->subject($esubject);
		$this->email->message($ebody);
		$this->email->attach("");
		if (is_array($attch_file)) {
			foreach ($attch_file as $key => $attach) {
				if ($key == 0) {
					$attch_files = $attach;
				} else {
					$attch_files .= ',' . $attach;
				}
				$this->email->attach($attach);
			}
		} else {
			if ($attch_file != "") $this->email->attach($attch_file);
			$attch_files = $attach_file;
		}

		//-----------------------------------//
		$ebody = addslashes($ebody);
		$eto = addslashes($eto);
		$esubj = addslashes($esubject);

		$myCDate = CurrMySqlDate();

		$_insert_array = array(
			"email_to" => $eto,
			"subj" => $esubj,
			"body" => $ebody,
			"send_time"	=> $myCDate,
		);

		if ($uid != "") $_insert_array['user_id'] = $uid;
		if ($ecc != "") $_insert_array['email_cc'] = $ecc;
		if ($attch_file != "") $_insert_array['attach_file'] = $attch_files;

		$_table = "email_log";
		//-----------------------------------//

		if ($eto != "") {
			if ($this->email->send()) {
				$_insert_array['is_send'] = "Y";
				$this->db->insert($_table, $_insert_array);
				return true;
				//echo 'Email sent.';
			} else {
				$log = addslashes($this->email->print_debugger());
				$_insert_array['log'] = $log;
				$_insert_array['is_send'] = "N";
				$_insert_array['is_send'] = "N";
				$this->db->insert($_table, $_insert_array);
				return false;
				//show_error($this->email->print_debugger());
			}
		}
	}
	
	public function getApprovedAssets($dfr_id)
	{

		$this->db->select("am.name,aa.assets_required");
		$this->db->where("aa.dfr_id", $dfr_id);
		$this->db->where("aa.approve!=", '2');
		$this->db->from("dfr_assets_approve aa");
		$this->db->join("dfr_assets_mst am", 'am.id=aa.assets_id', 'left');
		return $this->db->get();
		//    $this->db->get();
		//    echo $this->db->last_query();
		//    exit;
	}
}

