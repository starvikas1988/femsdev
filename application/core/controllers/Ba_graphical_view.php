<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ba_graphical_view extends CI_Controller {


	 function __construct() {
         parent::__construct();
         $this->load->model('user_model');
         $this->load->model('Common_model');
         $this->load->library('excel');
         $this->load->model('Email_model');
         $this->load->model('New_BA_Model');
         $this->objPHPExcel = new PHPExcel();
	 }

	public function index()
	{
        redirect(base_url()."ba_graphical_view/dashboard");
    }


    public function dashboard()
    {
        $is_global_access=get_global_access();
        $role_id        = get_role_id();
        $current_user   = get_user_id();
        $role_dir       = get_role_dir();
        $user_office_id = get_user_office_id();
        $ses_dept_id    = get_dept_id();

        $get_client_id  = get_client_ids();
        $get_process_id = get_process_ids();
        $get_user_site_id = get_user_site_id();


        //--------  DATE FILTER

        $startDate = date('Y-m-01', strtotime(CurrDate()));
        $endDate   = CurrDate();
        $start_time = "00:00:00";

        $extraFilter = ""; $extraTotal = "";
        if(!empty($this->input->get('start')))
        {
            $startDate = date('Y-m',strtotime($this->input->get('start')));
        }

        $assigned_user='';
        if(!empty($this->input->get('am')))
        {
            $assigned_user=$this->input->get('am');
        }

        $selected_tl='';
        if(!empty($this->input->get('tl')))
        {
            $selected_tl=$this->input->get('tl');
        }

        $selected_wave='';
        if(!empty($this->input->get('wave')))
        {
            $selected_wave=$this->input->get('wave');
        }

        $selected_qu='';
        if(!empty($this->input->get('queue')))
        {
            $selected_qu=$this->input->get('queue');
        }



        $startDateFull = $startDate ." " .$start_time;


        $data['currMonth'] = $get_month = date('m', strtotime($startDateFull));
        $data['currYear'] = $get_year = date('Y', strtotime($startDateFull));
        $data['totalDays'] = $totalDays = cal_days_in_month(CAL_GREGORIAN, $get_month, $get_year);

        $data['from_date'] = $startDate;
        $data['to_date'] = $endDate;
        $data['from_month'] = $from_month = $get_year ."-" .$get_month ."-" ."01";
        $data['to_month'] = $to_month = $get_year ."-" .$get_month ."-" .$totalDays;

        //--------  AGENT FILTER
        if($role_dir == "agent")
        {
            $extraFilter .= " AND (c.added_by = '$current_user') ";
            $extraTotal .= " AND (c.added_by = '$current_user') ";
        }



        $data['manager'] = $this->New_BA_Model->get_manager_list();
        $data['tl'] = $this->New_BA_Model->get_tl_list();
        $month=date('m',strtotime($startDate));
        $year=date('Y',strtotime($startDate));
        $data['graph_1']=$this->New_BA_Model->get_graph_data($month,$year,$assigned_user,$selected_tl,$selected_wave,$selected_qu,'477','478','5.5');

        $data['graph_2']=$this->New_BA_Model->get_graph_data($month,$year,$assigned_user,$selected_tl,$selected_wave,$selected_qu,'480','477','12');
        $data['graph_3']=$this->New_BA_Model->get_graph_data($month,$year,$assigned_user,$selected_tl,$selected_wave,$selected_qu,'482','483','90');
        $data['graph_4']=$this->New_BA_Model->get_graph_data($month,$year,$assigned_user,$selected_tl,$selected_wave,$selected_qu,'485','486','85');
        $data['graph_5']=$this->New_BA_Model->get_graph_data($month,$year,$assigned_user,$selected_tl,$selected_wave,$selected_qu,'660','660+661','100');
        $data['graph_6']=$this->New_BA_Model->get_graph_data($month,$year,$assigned_user,$selected_tl,$selected_wave,$selected_qu,'660','660+661','100');
        $data['graph_7']=$this->New_BA_Model->get_graph_data($month,$year,$assigned_user,$selected_tl,$selected_wave,$selected_qu,'660','660+661','100');
        $data['graph_8']=$this->New_BA_Model->get_graph_data($month,$year,$assigned_user,$selected_tl,$selected_wave,$selected_qu,'660','660+661','100');
        $data['graph_9']=$this->New_BA_Model->get_graph_data($month,$year,$assigned_user,$selected_tl,$selected_wave,$selected_qu,'660','660+661','100');
        $data['graph_10']=$this->New_BA_Model->get_graph_data($month,$year,$assigned_user,$selected_tl,$selected_wave,$selected_qu,'660','660+661','100');
        $data['graph_11']=$this->New_BA_Model->get_graph_data($month,$year,$assigned_user,$selected_tl,$selected_wave,$selected_qu,'660','660+661','100');

        $data['randomColors'] = array("#FAEBD7", "#FF7F50","#9ACD32", "#008000", "#FFA500", "#7B68EE", "#BC8F8F", "#FFF0F5", "#FF1493", "#CD853F", "#87CEEB", "#40E0D0", "#DB7093");
        $data['randomColors'] = array("#B23418", "#57B218", "#1BB87A", "#1DB4BB", "#0F7F85", "#CC1212", "#B95D32", "#55A03E", "#A2764B", "#B51183", "#7311B7", "#9D5E5F", "#2AB10F" );

        $data["aside_template"] = "ba_graphical_view/aside.php";
        $data["content_template"] = "ba_graphical_view/dashboard.php";
        $data["content_js"] = "ba_graphical_view/ba_graph_js.php";

        $this->load->view('dashboard',$data);
    }

    public function fetchtl(){
	     $am_id=$this->input->post('am_id');
        $html="<option value=''>All</option>";
        $data=$this->New_BA_Model->get_tl_list($am_id);
        foreach ($data as $dt)
        {
            $html .="<option value='".$dt['id']."'>".$dt['fullname']."</option>";
        }
        echo $html;
        exit;
    }
}
?>