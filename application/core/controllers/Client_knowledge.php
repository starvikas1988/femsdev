<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Client_knowledge extends CI_Controller {

    /////////////////////////////////////////////////////////////////////////////////////////////
    // INDEX PAGE
    /////////////////////////////////////////////////////////////////////////////////////////////
    
	 function __construct() {
		parent::__construct();
		$this->load->model('Common_model');
		$this->load->model('user_model');
	 }
	 
	public function index()
	{
		if(check_logged_in()){	
		    
			$_SESSION['pmenu'] = "1";
			$data["aside_template"] = "knowledge_base/aside.php";
			$data["content_template"] = "knowledge_base/main.php";
			
			$is_global_access=get_global_access();
			$current_user   = get_user_id();
			
			$user_office_id = get_user_office_id();
			$clients_client_id=get_clients_client_id();
			$clients_process_id=get_clients_process_id();

			
			$extra_office_filter = " AND k.office_id IN ('$user_office_id')";
			$extra_client_filter  = " AND k.client_id IN ($clients_client_id)";
			$extra_process_filter  = " AND k.process_id IN ($clients_process_id)";
			
			
			$qSQL="SELECT * FROM client where is_active=1 and client.id='".$clients_client_id."' ORDER BY shname";
			$query = $this->db->query($qSQL);
			$data['client_list'] = $query->result();
					
			
			
			// FILTER SEARCH
			$search_text = trim($this->input->get('search_text'));
			$search_office_id = trim($this->input->get('officeid'));
			$search_cat_id = trim($this->input->get('catid'));
			$extra_text = "";
			$extra_office = "";
			$extra_cat = "";
			$data['s_text'] = "";
			$data['s_office'] = "";
			$data['s_cat'] = "";
			if($search_text != '')
			{
				$data['s_text'] = $search_text;
				$extra_text = " AND (k.file_name LIKE '%$search_text%' OR k.tags LIKE '%$search_text%')";
			}
			
			if($search_office_id != '')
			{
				$data['s_office'] = $search_office_id;
				$extra_office = " AND k.office_id = '$search_office_id'";
			}
			
			if($search_cat_id != '')
			{
				$data['s_cat'] = $search_cat_id;
				$extra_cat = " AND k.category = '$search_cat_id'";
			}
			
			// SQL MAIN
			$qSql="SELECT k.*, c.shname as client_name, p.name as process_name, o.office_name as office_location FROM knowledge_base as k, client as c, process as p,office_location as o WHERE k.client_id = c.id AND k.process_id = p.id AND k.office_id = o.abbr AND k.file_type NOT IN ('video') $extra_cat $extra_office $extra_text $extra_client_filter $extra_office_filter $extra_process_filter GROUP BY k.process_id";
			
			//echo  $qSql;
			
			$data["knowledge_details"] = $clientArray = $this->Common_model->get_query_result_array($qSql);
			
			
			if(($search_office_id != "") || ($user_office_id != "")) {
				if($search_office_id != ""){ $user_office_id = $search_office_id; }
				$qSql="SELECT DISTINCT(category) as catname FROM knowledge_base WHERE office_id = '$user_office_id' AND client_id in ($clients_client_id) AND process_id in ($clients_process_id) AND category IS NOT NULL ORDER by catname ASC";
				$data["cat_array"] = $catArray = $this->Common_model->get_query_result_array($qSql);
			}
			
			
			
			//$qSql="SELECT abbr as office_id, office_name FROM office_location where abbr =(select office_id from signin_client where id='$current_user') ORDER BY office_name";
			
			$qSql="SELECT * FROM office_location where (select office_id from signin_client where id='$current_user') like CONCAT('%',abbr,'%')  ORDER BY office_name";
			
			$data['office_details'] = $this->Common_model->get_query_result_array($qSql);
					
			
			//  AND client_id = '$cid' AND office_id = '$oid' 
			
			// FILE ATTACHMENTS
			$file_array[] = array();
			foreach($clientArray as $tokenarray)
			{
				$pid = $tokenarray['process_id'];
				$cid = $tokenarray['client_id'];
				$oid = $tokenarray['office_id'];
				$file_id = "SELECT id, file_name, uploaded_name, office_id, client_id, process_id  from knowledge_base as k WHERE process_id = '$pid' AND k.file_type NOT IN ('video') $extra_cat $extra_client_filter $extra_office_filter $extra_process_filter $extra_text";
				$fileq = $this->db->query($file_id);
				$file_array[$pid] = $fileq->result_array();
			}
			$data['all_pu_attach'] = $file_array;
		
			$this->load->view('dashboard',$data);
		}
	}
	
	
	
	public function video()
	{
		if(check_logged_in()){	
		    
			$_SESSION['pmenu'] = "2";
			$data["aside_template"] = "knowledge_base/aside.php";
			$data["content_template"] = "knowledge_base/video.php";
			
			
			$is_global_access=get_global_access();
			$current_user   = get_user_id();
			
			$user_office_id = get_user_office_id();
			$clients_client_id=get_clients_client_id();
			$clients_process_id=get_clients_process_id();
			
			$extra_office_filter = " AND k.office_id IN ('$user_office_id')";
			$extra_client_filter  = " AND k.client_id IN ($clients_client_id)";
			$extra_process_filter  = " AND k.client_id IN ($clients_client_id)";
						
			
			$qSQL="SELECT * FROM client where is_active=1 and client.id='".$clients_client_id."' ORDER BY shname";
			$query = $this->db->query($qSQL);
			$data['client_list'] = $query->result();
			
			

			// FILTER SEARCH
			$search_text = trim($this->input->get('search_text'));
			$search_office_id = trim($this->input->get('officeid'));
			$search_cat_id = trim($this->input->get('catid'));
			$extra_text = "";
			$extra_cat = "";
			$extra_office = "";
			$data['s_text'] = "";
			$data['s_office'] = "";
			$data['s_cat'] = "";
			if($search_text != '')
			{
				$data['s_text'] = $search_text;
				$extra_text = " AND (k.file_name LIKE '%$search_text%' OR k.tags LIKE '%$search_text%')";
			}
			
			if($search_office_id != '')
			{
				$data['s_office'] = $search_office_id;
				$extra_office = " AND k.office_id = '$search_office_id'";
			}
			
			if($search_cat_id != '')
			{
				$data['s_cat'] = $search_cat_id;
				$extra_cat = " AND k.category = '$search_cat_id'";
			}
			
			// SQL MAIN
			$qSql="SELECT k.*, c.shname as client_name, p.name as process_name, o.office_name as office_location FROM knowledge_base as k, client as c, process as p,office_location as o WHERE k.client_id = c.id AND k.process_id = p.id AND k.office_id = o.abbr AND k.file_type = 'video' $extra_office $extra_text $extra_office_filter $extra_client_filter $extra_process_filter GROUP BY k.process_id";
			
			$data["knowledge_details"] = $clientArray = $this->Common_model->get_query_result_array($qSql);
			
			
			//$qSql="SELECT abbr as office_id, office_name FROM office_location where abbr =(select office_id from signin_client where id='$current_user') ORDER BY office_name";
			$qSql="SELECT * FROM office_location where (select office_id from signin_client where id='$current_user') like CONCAT('%',abbr,'%')  ORDER BY office_name";
			$data['office_details'] = $this->Common_model->get_query_result_array($qSql);
			
			if($search_office_id != ""){
				$qSql="SELECT DISTINCT(category) as catname FROM knowledge_base WHERE office_id = '$search_office_id' AND client_id in ($clients_client_id) AND process_id in ($clients_process_id) AND file_type = 'video' AND category IS NOT NULL ORDER by catname ASC";
				$data["cat_array"] = $catArray = $this->Common_model->get_query_result_array($qSql);
			}
			
			// FILE ATTACHMENTS
			$file_array[] = array();
			foreach($clientArray as $tokenarray)
			{
				$pid = $tokenarray['process_id'];
				$cid = $tokenarray['client_id'];
				$oid = $tokenarray['office_id'];
				$file_id = "SELECT id, file_name, uploaded_name, office_id, client_id, process_id from knowledge_base as k WHERE process_id = '$pid' AND file_type = 'video'  $extra_client_filter $extra_office_filter $extra_process_filter $extra_text";
				$fileq = $this->db->query($file_id);
				$file_array[$pid] = $fileq->result_array();
			}
			$data['all_pu_attach'] = $file_array;
		
			$this->load->view('dashboard',$data);
		}
	}
	
	
	
	
	
	public function viewdata()
	{
		if(check_logged_in()){
			
			$log            = get_logs();
			$role_id        = get_role_id();
			$current_user   = get_user_id();
			$role_dir       = get_role_dir();			
			$user_office_id = get_user_office_id();
			$ses_dept_id    = get_dept_id();	
			$curDateTime    = CurrMySqlDate();
			
			
			$file_id = trim($this->input->post('kid'));
			
			$file_sql  = "SELECT * from knowledge_base WHERE id = '$file_id'";
			$fileArray = $this->Common_model->get_query_row_array($file_sql);
			
			// ---- STORE VIEW RECORDS
			$qSql="SELECT count(*) as value from knowledge_records WHERE uid='$current_user' AND kid = '$file_id'";
			$qrecord =$this->Common_model->get_single_value($qSql);
			if($qrecord > 0)
			{
				
				$qSqlu="UPDATE knowledge_records SET vcount = vcount+1, date = '$curDateTime', log = '$log' WHERE uid = '$current_user' AND kid = '$file_id'";
				$this->db->query($qSqlu);
				
			} else {
				
				$field_array = array(
					"uid" => $current_user,
					"kid" => $file_id,
					"vcount" => '1',
					"date" => $curDateTime,
					"log" => $log
				);
				$view_count=data_inserter('knowledge_records',$field_array);
				
			}
			
			$data['fileArray'] = $fileArray;
			$this->load->view('knowledge_base/documentview',$data);
			
			
			/*
			$file_dir = base_url() ."uploads/knowledge_base/" .$fileArray['office_id'] ."/" .$fileArray['client_id'] ."/" .$fileArray['process_id'] ."/" .$fileArray['uploaded_name'];

			if($fileArray['file_type'] == 'video')
			{
				echo '<video controls><source src="'.$file_dir.'" type="video/mp4"></video>';
			}

			if($fileArray['file_type'] == 'image')
			{
				echo '<img src="'.$file_dir.'"></img>';
			}

			if($fileArray['file_type'] == 'document')
			{
				echo "Original Filename : " .$fileArray['file_name'];
				echo "<br/>Uploade Filename : " .$fileArray['uploaded_name'];
				echo "<br/> Date Uploaded : " .$fileArray['added_date'];
				
				echo "<br/><br/>";
				
				echo "<a class='btn btn-primary' href='".$file_dir."'> <i class='fa fa-download'></i> Download</a>";
				
			}
			*/
			
		
		}
	}
	
	
	public function fileviewdata()
	{
		
		$kid = $this->input->get('kid');
		
		if($kid != ""){
			
			//--- GET VIEWS
			$qview = "SELECT count(*) as viewcount, sum(vcount) as totalcount from knowledge_records WHERE kid = '$kid'";
			$qrecord = $this->Common_model->get_query_row_array($qview);
			$data['viewcount'] = $viewcount = $qrecord['viewcount'];
			$data['totalcount'] = $totalcount = $qrecord['totalcount'];
			
			echo "<i class='fa fa-eye'></i> ".$viewcount ." viewed";
			
		}
		
	}
	
	
	public function filerecord()
	{
		
		$kid = $this->input->get('kid');
		
		if($kid != ""){
			
			//--- GET VIEWS
			$qview = "SELECT k.vcount as viewcount, s.fusion_id as fusion_id, concat(s.fname,' ',s.lname) as fullname, d.d_fullname as department, r.rolename as designation, k.date as date from knowledge_records as k
			  LEFT JOIN signin as s on k.uid = s.id
			  LEFT JOIN (SELECT id as depid, description as d_fullname, shname as d_shortname from department) as d ON d.depid = s.dept_id
			  LEFT JOIN (SELECT id as cid, shname as c_shortname, fullname as c_fullname from client) as c ON c.cid = s.client_id
			  LEFT JOIN (SELECT id as pid, name as p_fullname from process) as p ON p.pid = s.process_id
			  LEFT JOIN (SELECT abbr as shortform, office_name from office_location) as o ON o.shortform = s.office_id
			  LEFT JOIN (SELECT id as lid, concat(fname, ' ', lname) as lpname from signin) as a ON a.lid = s.assigned_to
			  LEFT JOIN (SELECT id as rid, name as rolename from role) as r ON r.rid = s.role_id
			  LEFT JOIN (SELECT id as roid, name as roleorgname from role_organization) as rg ON rg.roid = s.org_role_id
			  WHERE k.kid = '$kid' ORDER by s.dept_id, rg.roid, r.rid";
			
			$data['viewdata'] = $qrecord = $this->Common_model->get_query_result_array($qview);
			$this->load->view('knowledge_base/viewcountfile',$data);
			
		}
		
	}
	
	
	
	//--- EXCEL READER -------//
	public function checkexcel()
	{
		$this->load->library('excel');
		
		$file_id = $this->uri->segment(3);
		$file_sql  = "SELECT * from knowledge_base WHERE id = '$file_id'";
		$fileArray = $this->Common_model->get_query_row_array($file_sql);
		$data['fileArray'] = $fileArray;
		$file_dir = "uploads/knowledge_base/" .$fileArray['office_id'] ."/" .$fileArray['client_id'] ."/" .$fileArray['process_id'] ."/" .$fileArray['uploaded_name'];
		
		$file_path = $file_dir;
		$inputFileType = PHPExcel_IOFactory::identify($file_path);
		echo "<title>View File - ".$fileArray['file_name'] ."</title>";
		echo "<style>body{ cursor:cell; } th,td{ border:1px solid #ccc!important; } th:focus,th:active,td:focus,td:active{ background-color:#ccc; border:2px solid #222!important; } .selectedcell{ background-color : #3297FD!important; border:2px solid #222!important; color:#ffffff!important; } td::selection{ background-color:#3297FD; color:#ffffff; } .box{ text-align: right; } .alertbox{ display: none; position: absolute; background-color:#d4e6d4; color:#333; padding: 5px 10px; font-weight: 400; border-radius: 5px; } </style>";
		
		$objReader = PHPExcel_IOFactory::createReader($inputFileType);
		$sheetno = $this->uri->segment(4);
		$objPHPExcel = $objReader->load($file_path); 
		$sheetCount = $objPHPExcel->getSheetCount();
		$worksheetname = $objPHPExcel->getSheetNames();
		$i=0;
		foreach($worksheetname as $tokenn)
		{
			$mycolor = "#f6f7f9";
			if($i == $sheetno){ $mycolor = "#d6e1f2"; }
			echo "<a style='padding:4px 10px;background-color:".$mycolor.";color:#000;text-decoration:none;border-radius:2px;' href='".base_url()."/knowledge/checkexcel/".$file_id."/".$i."'> &#128206; ".$tokenn ."</a> ";
			$i++;
		}
		echo "<br/><br/><br/>";
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'HTML');
		$objWriter->setSheetIndex($sheetno);
		header("Content-Type: text/html");
		$objWriter->save("php://output");
		
		echo "<div class='alertbox'>Selected Content Copied!</div><div style='display:block;opacity:0' id='contentselection'></div>";
		echo "<script src='".base_url()."libs/bower/jquery/dist/jquery.js'></script>";
		echo $checkscript = <<<SCR
		<script>
		$('td').on("click", function (evt){
			if (evt.ctrlKey){
				$(this).toggleClass("selectedcell");
		     }
			 else if (evt.shiftKey){
				$(this).toggleClass("selectedcell");
				f_td = $('.selectedcell').first().index();
				f_tr = $('.selectedcell').parent('tr').first().index();
				l_td = $('.selectedcell').last().index();
				l_tr = $('.selectedcell').parent('tr').last().index();				
				for(i=f_tr;i<=l_tr;i++){
				   totaltd = $('tr:eq('+i+') td').length;
				   for(j=0;j<=totaltd;j++){
					 if(((i==f_tr) && (j<f_td)) || ((i==l_tr) && (j>l_td))){ }
					 else { $('tr:eq('+i+') td:eq('+j+')').addClass('selectedcell'); }
				   }
				}
		     }
			 else {
				$('td').removeClass('selectedcell');
				$(this).addClass('selectedcell');
			 }

			mycontent = "";
			// GET ALL SELECTED CONTENT
			$('.selectedcell').each(function(){
				mycontent += $(this).html();
				mycontent += "&nbsp;&nbsp;";
			});
			
			$('#contentselection').html(mycontent);
			const referenceNode = document.getElementById('contentselection');
			var range = document.createRange();
			range.selectNodeContents(referenceNode);  
			var sel = window.getSelection(); 
			sel.removeAllRanges(); 
			sel.addRange(range);
			document.execCommand('copy');
			$(".alertbox").css({
				top: evt.pageY,
				left: evt.pageX
			}).toggle();
			$('.alertbox').show();
			$('.alertbox').delay(600).fadeOut();
		});
		</script>
SCR;
		
	}
	
	
	//------- WORD READER ------//
	public function checkword()
	{
		$this->load->library('word');
		
		$file_id = $this->uri->segment(3);
		$file_sql  = "SELECT * from knowledge_base WHERE id = '$file_id'";
		$fileArray = $this->Common_model->get_query_row_array($file_sql);
		$data['fileArray'] = $fileArray;
		$file_dir = "uploads/knowledge_base/" .$fileArray['office_id'] ."/" .$fileArray['client_id'] ."/" .$fileArray['process_id'] ."/" .$fileArray['uploaded_name'];
		
		$file_path = $file_dir;
		$phpWord = PHPWord_IOFactory::load($file_path);
		echo "<title>View File - ".$fileArray['file_name'] ."</title>";
		$objWriter = PHPWord_IOFactory::createWriter($phpWord, 'HTML');
		header("Content-Type: text/html");
		$objWriter->save('php://output');
				
	}
	
	
	
	
	
   
	
}