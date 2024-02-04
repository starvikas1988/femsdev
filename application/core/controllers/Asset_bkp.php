<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Asset_bkp extends CI_Controller {
    
    /////////////////////////////////////////////////////////////////////////////////////////////
    // INDEX PAGE
    /////////////////////////////////////////////////////////////////////////////////////////////
    private $aside = "asset/aside.php";
	 function __construct() {
		parent::__construct();
		
		$this->load->model('auth_model');
		$this->load->model('Common_model');
		
	 }
	
    public function index()
    {			
		if(check_logged_in())
        {
			
			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_id();
			$data["aside_template"] = $this->aside;
			$qSql="SELECT p.*,ofc.location as loc,c.name as category,b.name as brand_name,a.name FROM asset_stock as p left join master_asset_category as c on c.id=p.product_category_id left join master_asset_brand as b on b.id=p.brand left join office_location as ofc on ofc.abbr=p.location left join master_asset_products as a on a.id=p.product_id";
			$data['prod_list'] = $this->Common_model->get_query_result_array($qSql);

			$qSqlcat="SELECT * FROM master_asset_category where is_active=1";
			$data['cat_list'] = $this->Common_model->get_query_result_array($qSqlcat);

			$qSqlprod="SELECT * FROM master_asset_products where is_active=1";
			$data['pro_list'] = $this->Common_model->get_query_result_array($qSqlprod);

			$qSqlbrand="SELECT * FROM master_asset_brand where is_active=1";
			$data['brand_list'] = $this->Common_model->get_query_result_array($qSqlbrand);

			$qSqlprocessor="SELECT * FROM master_asset_minimun_processor where is_active=1";
			$data['processor_list'] = $this->Common_model->get_query_result_array($qSqlprocessor);

			$qSqlhdd="SELECT * FROM master_asset_minimun_hard_disk_drive where is_active=1";
			$data['hdd_list'] = $this->Common_model->get_query_result_array($qSqlhdd);

			$qSqlram="SELECT * FROM master_asset_minimun_ram where is_active=1";
			$data['ram_list'] = $this->Common_model->get_query_result_array($qSqlram);

			$qSqldisplay="SELECT * FROM master_asset_system_screen_size where is_active=1";
			$data['display_list'] = $this->Common_model->get_query_result_array($qSqldisplay);

			$data["content_template"] = "asset/add_stock.php";
            $data["content_js"] = "asset_js.php";
            $data["error"] = ''; 	


			
			$this->load->view('dashboard',$data);
								
        }			
	}


	private function check_access()
	{
		if(get_global_access()!='1' && get_dept_folder() !="hr" && get_role_dir()!="super") redirect(base_url()."home","refresh");
	}


	public function add_stock()
	{
		if(check_logged_in())
		{
			$current_loc = get_user_office_id();
			$name = trim($this->input->post('pro_id'));
			$cat_id = trim($this->input->post('cat_id'));
			$brand_id = trim($this->input->post('brand_id'));
			$ram_id = trim($this->input->post('ram_id'));
			$processor_id = trim($this->input->post('processor_id'));
			$display_id = trim($this->input->post('display_id'));
			$hdd_id = trim($this->input->post('hdd_id'));
			$desc = trim($this->input->post('desc'));
			$quant = trim($this->input->post('quant'));

			$log=get_logs();
			
			if($name!=""){
				
				$field_array = array(
					"product_id" => $name,
					"product_category_id" => $cat_id,
					"brand" => $brand_id,
					"ram" => $ram_id,
					"display" => $display_id,
					"hard_disk" => $hdd_id,
					"processor" => $processor_id,
					"description" => $desc,
					"quantity" => $quant,
					"location" =>$current_loc,
					"is_active" => '1',
					"log" => $log
				);
				$rowid= data_inserter('asset_stock',$field_array);
							
				$ans="done";
			}else{
				$ans="error";
			}
			
			echo $ans;
		}
	}
	   
	public function update_stock()
	{
		if(check_logged_in())
		{
			
			$rid = trim($this->input->post('rid'));
			$name = trim($this->input->post('pro_id'));
			$cat_id = trim($this->input->post('cat_id'));
			$brand_id = trim($this->input->post('brand_id'));
			$ram_id = trim($this->input->post('ram_id'));
			$processor_id = trim($this->input->post('processor_id'));
			$display_id = trim($this->input->post('display_id'));
			$hdd_id = trim($this->input->post('hdd_id'));
			$desc = trim($this->input->post('desc'));
			$quant = trim($this->input->post('quant'));

			if($rid!=""){
				
				$log=get_logs();
				
				$field_array = array(
					"product_id" => $name,
					"product_category_id" => $cat_id,
					"brand" => $brand_id,
					"ram" => $ram_id,
					"display" => $display_id,
					"hard_disk" => $hdd_id,
					"processor" => $processor_id,
					"description" => $desc,
					"quantity" => $quant,
					"log" => $log
				); 
			
				$this->db->where('id', $rid);
				$this->db->update('asset_stock', $field_array);
				$ans="done";
			}else{
				$ans="error";
			}
			echo $ans;
		}
	}
	

	public function request($id){
		if(check_logged_in())
        {
			
			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_fusion_id();
			$data["aside_template"] = $this->aside;

			$qSql="SELECT r.*,ofc.location as loc,c.name as cat,h.size as hdd,mp.processor as pro,mr.size as ram_size,p.name as prod,ms.size as disp FROM asset_request as r left join master_asset_category as c on c.id = r.product_category_id left join master_asset_minimun_hard_disk_drive as h on h.id = r.hard_disk left join master_asset_minimun_processor as mp on mp.id = r.processor left join master_asset_minimun_ram as mr on mr.id = r.ram left join master_asset_products as p on p.id = r.product_id left join master_asset_system_screen_size as ms on ms.id = r.display left join office_location as ofc on ofc.abbr = r.location where request_type = 2";
			if($id!=1)$qSql .= " and requested_by = '".$current_user."'";
			$data['req_list'] = $this->Common_model->get_query_result_array($qSql);


			if($id == 1){
				$data["content_template"] = "asset/req_list.php";
			}else{
				$qSqlcat="SELECT * FROM master_asset_category where is_active=1";
				$data['cat_list'] = $this->Common_model->get_query_result_array($qSqlcat);

				$qSqlprod="SELECT * FROM master_asset_products where is_active=1";
				$data['pro_list'] = $this->Common_model->get_query_result_array($qSqlprod);

				$qSqlbrand="SELECT * FROM master_asset_brand where is_active=1";
				$data['brand_list'] = $this->Common_model->get_query_result_array($qSqlbrand);

				$qSqlprocessor="SELECT * FROM master_asset_minimun_processor where is_active=1";
				$data['processor_list'] = $this->Common_model->get_query_result_array($qSqlprocessor);

				$qSqlhdd="SELECT * FROM master_asset_minimun_hard_disk_drive where is_active=1";
				$data['hdd_list'] = $this->Common_model->get_query_result_array($qSqlhdd);

				$qSqlram="SELECT * FROM master_asset_minimun_ram where is_active=1";
				$data['ram_list'] = $this->Common_model->get_query_result_array($qSqlram);

				$qSqldisplay="SELECT * FROM master_asset_system_screen_size where is_active=1";
				$data['display_list'] = $this->Common_model->get_query_result_array($qSqldisplay);
				$data["content_template"] = "asset/add_request.php";
			}
			
            $data["content_js"] = "asset_js.php";
            $data["error"] = ''; 	


			
			$this->load->view('dashboard',$data);
								
        }
	}


	public function approve()
	{
		if(check_logged_in())
		{
			$current_user = get_user_fusion_id();
			$rid = trim($this->input->post('pid'));
			$status = trim($this->input->post('sid'));
			$date = date('Y-m-d');

			if($rid!=""){
				
				$log=get_logs();
				
				$field_array = array(
					"status" => $status,
					"approved_by" => $current_user,
					"approved_date" => $date,
					"log" => $log
				); 
			
				$this->db->where('id', $rid);
				$this->db->update('asset_request', $field_array);
				$ans="done";
			}else{
				$ans="error";
			}
			echo $ans;
		}
	}

	public function reject()
	{
		if(check_logged_in())
		{
			$current_user = get_user_fusion_id();
			$rid = trim($this->input->post('pid'));
			$status = trim($this->input->post('sid'));
			$date = date('Y-m-d');

			if($rid!=""){
				
				$log=get_logs();
				
				$field_array = array(
					"status" => $status,
					"rejected_by" => $current_user,
					"rejected_date" => $date,
					"log" => $log
				); 
			
				$this->db->where('id', $rid);
				$this->db->update('asset_request', $field_array);
				$ans="done";
			}else{
				$ans="error";
			}
			echo $ans;
		}
	}

	public function add_reqPurchase()
	{
		if(check_logged_in())
		{	
			$current_loc = get_user_office_id();
			$current_user = get_user_fusion_id();
			$date = date('Y-m-d');
			$name = trim($this->input->post('pro_id'));
			$cat_id = trim($this->input->post('cat_id'));
			$brand_id = trim($this->input->post('brand_id'));
			$ram_id = trim($this->input->post('ram_id'));
			$processor_id = trim($this->input->post('processor_id'));
			$display_id = trim($this->input->post('display_id'));
			$hdd_id = trim($this->input->post('hdd_id'));
			$desc = trim($this->input->post('desc'));
			$quant = trim($this->input->post('quant'));

			$log=get_logs();
			
			if($name!=""){
				
				$field_array = array(
					"request_type" => 1,
					"product_id" => $name,
					"product_category_id" => $cat_id,
					"ram" => $ram_id,
					"display" => $display_id,
					"hard_disk" => $hdd_id,
					"processor" => $processor_id,
					"product_description" => $desc,
					"requested_by" => $current_user,
					"request_date" => $date,
					"quantity" => $quant,
					"location" => $current_loc,
					"status" => 1,
					"log" => $log
				);
				$rowid= data_inserter('asset_request',$field_array);
							
				$ans="done";
			}else{
				$ans="error";
			}
			
			echo $ans;
		}
	}




////////////////////////////ram ///////////////////////////////
      
    public function ram()
    {
        if(check_logged_in())
        {
			$this->check_access();
			
			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_id();
			
            //$data["aside_template"] = get_aside_template();
			$data["aside_template"] = $this->aside;
			
            $data["content_template"] = "asset/ram.php";
            $data["content_js"] = "asset_js.php";
            $data["error"] = ''; 
            $data['srole_id']=$srole_id;		
            
				$qSql="SELECT * FROM master_asset_minimun_ram";
				$data['ram_list'] = $this->Common_model->get_query_result_array($qSql);
			
			   $this->load->view('dashboard',$data);
								
            }                  
   }
   
    
	public function addRam()
	{
		if(check_logged_in())
		{
			$this->check_access();
			
			$name = trim($this->input->post('name'));
			
			$log=get_logs();
			
			if($name!=""){
				
				$field_array = array(
					"size" => $name,
					"is_active" => '1',
					"log" => $log
				);
				$rowid= data_inserter('master_asset_minimun_ram',$field_array);
							
				$ans="done";
			}else{
				$ans="error";
			}
			
			echo $ans;
		}
	}
	   
	public function updateRam()
	{
		if(check_logged_in())
		{
			
			$this->check_access();
			
			$rid = trim($this->input->post('rid'));
			$name = trim($this->input->post('name'));
			
			if($rid!=""){
				
				$log=get_logs();
				
				$field_array = array(
					"size" => $name,
					"log" => $log
				); 
			
				$this->db->where('id', $rid);
				$this->db->update('master_asset_minimun_ram', $field_array);
				$ans="done";
			}else{
				$ans="error";
			}
			echo $ans;
		}
	}

	   
	public function ramActDeact()
	{
		if(check_logged_in())
		{
			$this->check_access();
			
			$rid = trim($this->input->post('rid'));
			$sid = trim($this->input->post('sid'));
			
			if($rid!=""){
				$this->db->where('id', $rid);
				$this->db->update('master_asset_minimun_ram', array('is_active' => $sid));
				$ans="done";
			}else{
				$ans="error";
			}
			echo $ans;
		}
	}



////////////////////////////processor ///////////////////////////////
      
    public function processor()
    {
        if(check_logged_in())
        {
			$this->check_access();
			
			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_id();
			
            //$data["aside_template"] = get_aside_template();
			$data["aside_template"] = $this->aside;
			
            $data["content_template"] = "asset/processor.php";
            $data["content_js"] = "asset_js.php";
            $data["error"] = ''; 
            $data['srole_id']=$srole_id;		
            
				$qSql="SELECT * FROM master_asset_minimun_processor";
				$data['processor_list'] = $this->Common_model->get_query_result_array($qSql);
			
			   $this->load->view('dashboard',$data);
								
            }                  
   }
   
    
	public function addProcessor()
	{
		if(check_logged_in())
		{
			$this->check_access();
			
			$name = trim($this->input->post('name'));
			
			$log=get_logs();
			
			if($name!=""){
				
				$field_array = array(
					"processor" => $name,
					"is_active" => '1',
					"log" => $log
				);
				$rowid= data_inserter('master_asset_minimun_processor',$field_array);
							
				$ans="done";
			}else{
				$ans="error";
			}
			
			echo $ans;
		}
	}
	   
	public function updateProcessor()
	{
		if(check_logged_in())
		{
			
			$this->check_access();
			
			$rid = trim($this->input->post('rid'));
			$name = trim($this->input->post('name'));
			
			if($rid!=""){
				
				$log=get_logs();
				
				$field_array = array(
					"processor" => $name,
					"log" => $log
				); 
			
				$this->db->where('id', $rid);
				$this->db->update('master_asset_minimun_processor', $field_array);
				$ans="done";
			}else{
				$ans="error";
			}
			echo $ans;
		}
	}

	   
	public function processorActDeact()
	{
		if(check_logged_in())
		{
			$this->check_access();
			
			$rid = trim($this->input->post('rid'));
			$sid = trim($this->input->post('sid'));
			
			if($rid!=""){
				$this->db->where('id', $rid);
				$this->db->update('master_asset_minimun_processor', array('is_active' => $sid));
				$ans="done";
			}else{
				$ans="error";
			}
			echo $ans;
		}
	}


////////////////////////////hardDisk ///////////////////////////////
      
    public function hard_disk()
    {
        if(check_logged_in())
        {
			$this->check_access();
			
			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_id();
			
            //$data["aside_template"] = get_aside_template();
			$data["aside_template"] = $this->aside;
			
            $data["content_template"] = "asset/hard_disk.php";
            $data["content_js"] = "asset_js.php";
            $data["error"] = ''; 
            $data['srole_id']=$srole_id;		
            
				$qSql="SELECT * FROM master_asset_minimun_hard_disk_drive";
				$data['hdd_list'] = $this->Common_model->get_query_result_array($qSql);
			
			   $this->load->view('dashboard',$data);
								
            }                  
   }
   
    
	public function addHardDisk()
	{
		if(check_logged_in())
		{
			$this->check_access();
			
			$name = trim($this->input->post('name'));
			
			$log=get_logs();
			
			if($name!=""){
				
				$field_array = array(
					"size" => $name,
					"is_active" => '1',
					"log" => $log
				);
				$rowid= data_inserter('master_asset_minimun_hard_disk_drive',$field_array);
							
				$ans="done";
			}else{
				$ans="error";
			}
			
			echo $ans;
		}
	}
	   
	public function updateHardDisk()
	{
		if(check_logged_in())
		{
			
			$this->check_access();
			
			$rid = trim($this->input->post('rid'));
			$name = trim($this->input->post('name'));
			
			if($rid!=""){
				
				$log=get_logs();
				
				$field_array = array(
					"size" => $name,
					"log" => $log
				); 
			
				$this->db->where('id', $rid);
				$this->db->update('master_asset_minimun_hard_disk_drive', $field_array);
				$ans="done";
			}else{
				$ans="error";
			}
			echo $ans;
		}
	}

	   
	public function hardDiskActDeact()
	{
		if(check_logged_in())
		{
			$this->check_access();
			
			$rid = trim($this->input->post('rid'));
			$sid = trim($this->input->post('sid'));
			
			if($rid!=""){
				$this->db->where('id', $rid);
				$this->db->update('master_asset_minimun_hard_disk_drive', array('is_active' => $sid));
				$ans="done";
			}else{
				$ans="error";
			}
			echo $ans;
		}
	}



////////////////////////////Screen Size ///////////////////////////////
      
    public function screen_size()
    {
        if(check_logged_in())
        {
			$this->check_access();
			
			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_id();
			
            //$data["aside_template"] = get_aside_template();
			$data["aside_template"] = $this->aside;
			
            $data["content_template"] = "asset/screen_size.php";
            $data["content_js"] = "asset_js.php";
            $data["error"] = ''; 
            $data['srole_id']=$srole_id;			
            
				$qSql="SELECT * FROM master_asset_system_screen_size";
				$data['screen_list'] = $this->Common_model->get_query_result_array($qSql);
			
			   $this->load->view('dashboard',$data);
								
            }                  
   }
   
    
public function add_screen_size()
	{
		if(check_logged_in())
		{
			$this->check_access();
			
			$name = trim($this->input->post('name'));
			
			$log=get_logs();
			
			if($name!=""){
				
				$field_array = array(
					"size" => $name,
					"is_active" => '1',
					"log" => $log
				);
				$rowid= data_inserter('master_asset_system_screen_size',$field_array);
							
				$ans="done";
			}else{
				$ans="error";
			}
			
			echo $ans;
		}
	}
	   
	public function update_screen_size()
	{
		if(check_logged_in())
		{
			
			$this->check_access();
			
			$rid = trim($this->input->post('rid'));
			$name = trim($this->input->post('name'));
			
			if($rid!=""){
				
				$log=get_logs();
				
				$field_array = array(
					"size" => $name,
					"log" => $log
				); 
			
				$this->db->where('id', $rid);
				$this->db->update('master_asset_system_screen_size', $field_array);
				$ans="done";
			}else{
				$ans="error";
			}
			echo $ans;
		}
	}

	   
	public function screen_sizeActDeact()
	{
		if(check_logged_in())
		{
			$this->check_access();
			
			$rid = trim($this->input->post('rid'));
			$sid = trim($this->input->post('sid'));
			
			if($rid!=""){
				$this->db->where('id', $rid);
				$this->db->update('master_asset_system_screen_size', array('is_active' => $sid));
				$ans="done";
			}else{
				$ans="error";
			}
			echo $ans;
		}
	}


////////////////////////////category///////////////////////////////
      
    public function category()
    {
        if(check_logged_in())
        {
			$this->check_access();
			
			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_id();
			
            //$data["aside_template"] = get_aside_template();
			$data["aside_template"] = $this->aside;
			
            $data["content_template"] = "asset/category.php";
            $data["content_js"] = "asset_js.php";
            $data["error"] = ''; 
            $data['srole_id']=$srole_id;		
            
				$qSql="SELECT * FROM master_asset_category";
				$data['cat_list'] = $this->Common_model->get_query_result_array($qSql);
			
			   $this->load->view('dashboard',$data);
								
            }                  
   }
   
    
	public function add_category()
	{
		if(check_logged_in())
		{
			$this->check_access();
			
			$name = trim($this->input->post('name'));
			
			$log=get_logs();
			
			if($name!=""){
				
				$field_array = array(
					"name" => $name,
					"is_active" => '1',
					"log" => $log
				);
				$rowid= data_inserter('master_asset_category',$field_array);
							
				$ans="done";
			}else{
				$ans="error";
			}
			
			echo $ans;
		}
	}
	   
	public function update_category()
	{
		if(check_logged_in())
		{
			
			$this->check_access();
			
			$rid = trim($this->input->post('rid'));
			$name = trim($this->input->post('name'));
			
			if($rid!=""){
				
				$log=get_logs();
				
				$field_array = array(
					"name" => $name,
					"log" => $log
				); 
			
				$this->db->where('id', $rid);
				$this->db->update('master_asset_category', $field_array);
				$ans="done";
			}else{
				$ans="error";
			}
			echo $ans;
		}
	}

	   
	public function categoryActDeact()
	{
		if(check_logged_in())
		{
			$this->check_access();
			
			$rid = trim($this->input->post('rid'));
			$sid = trim($this->input->post('sid'));
			
			if($rid!=""){
				$this->db->where('id', $rid);
				$this->db->update('master_asset_category', array('is_active' => $sid));
				$ans="done";
			}else{
				$ans="error";
			}
			echo $ans;
		}
	}	



////////////////////////////product///////////////////////////////
      
    public function product()
    {
        if(check_logged_in())
        {
			$this->check_access();
			
			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_id();
			
            //$data["aside_template"] = get_aside_template();
			$data["aside_template"] = $this->aside;
			
            $data["content_template"] = "asset/products.php";
            $data["content_js"] = "asset_js.php";
            $data["error"] = ''; 
            $data['srole_id']=$srole_id;		
            
				$qSql="SELECT p.*,c.name as category,b.name as brand FROM master_asset_products as p left join master_asset_category as c on c.id=p.cat_id left join master_asset_brand as b on b.id=p.brand_id";
				$data['prod_list'] = $this->Common_model->get_query_result_array($qSql);

				$qSqlcat="SELECT * FROM master_asset_category where is_active=1";
				$data['cat_list'] = $this->Common_model->get_query_result_array($qSqlcat);

				$qSqlbrand="SELECT * FROM master_asset_brand where is_active=1";
				$data['brand_list'] = $this->Common_model->get_query_result_array($qSqlbrand);
			
			   $this->load->view('dashboard',$data);
								
            }                  
   }
   
    
	public function add_product()
	{
		if(check_logged_in())
		{
			$this->check_access();
			
			$name = trim($this->input->post('name'));
			$cat_id = trim($this->input->post('cat_id'));
			$brand_id = trim($this->input->post('brand_id'));

			$log=get_logs();
			
			if($name!=""){
				
				$field_array = array(
					"name" => $name,
					"cat_id" => $cat_id,
					"brand_id" => $brand_id,
					"is_active" => '1',
					"log" => $log
				);
				$rowid= data_inserter('master_asset_products',$field_array);
							
				$ans="done";
			}else{
				$ans="error";
			}
			
			echo $ans;
		}
	}
	   
	public function update_product()
	{
		if(check_logged_in())
		{
			
			$this->check_access();
			
			$rid = trim($this->input->post('rid'));
			$name = trim($this->input->post('name'));
			$cat_id = trim($this->input->post('cat_id'));
			$brand_id = trim($this->input->post('brand_id'));

			if($rid!=""){
				
				$log=get_logs();
				
				$field_array = array(
					"name" => $name,
					"cat_id" => $cat_id,
					"brand_id" => $brand_id,
					"log" => $log
				); 
			
				$this->db->where('id', $rid);
				$this->db->update('master_asset_products', $field_array);
				$ans="done";
			}else{
				$ans="error";
			}
			echo $ans;
		}
	}

	   
	public function productActDeact()
	{
		if(check_logged_in())
		{
			$this->check_access();
			
			$rid = trim($this->input->post('rid'));
			$sid = trim($this->input->post('sid'));
			
			if($rid!=""){
				$this->db->where('id', $rid);
				$this->db->update('master_asset_products', array('is_active' => $sid));
				$ans="done";
			}else{
				$ans="error";
			}
			echo $ans;
		}
	}

////////////////////////////Brand///////////////////////////////
      
    public function brand()
    {
        if(check_logged_in())
        {
			$this->check_access();
			
			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_id();
			
            //$data["aside_template"] = get_aside_template();
			$data["aside_template"] = $this->aside;
			
            $data["content_template"] = "asset/brand.php";
            $data["content_js"] = "asset_js.php";
            $data["error"] = ''; 
            $data['srole_id']=$srole_id;		

				$qSql="SELECT * FROM master_asset_brand";
				$data['brand_list'] = $this->Common_model->get_query_result_array($qSql);
			
			   $this->load->view('dashboard',$data);
								
            }                  
   }
   
    
	public function add_brand()
	{
		if(check_logged_in())
		{
			$this->check_access();
			
			$name = trim($this->input->post('name'));
			
			$log=get_logs();
			
			if($name!=""){
				
				$field_array = array(
					"name" => $name,
					"is_active" => '1',
					"log" => $log
				);
				$rowid= data_inserter('master_asset_brand',$field_array);
							
				$ans="done";
			}else{
				$ans="error";
			}
			
			echo $ans;
		}
	}
	   
	public function update_brand()
	{
		if(check_logged_in())
		{
			
			$this->check_access();
			
			$rid = trim($this->input->post('rid'));
			$name = trim($this->input->post('name'));

			if($rid!=""){
				
				$log=get_logs();
				
				$field_array = array(
					"name" => $name,
					"log" => $log
				); 
			
				$this->db->where('id', $rid);
				$this->db->update('master_asset_brand', $field_array);
				$ans="done";
			}else{
				$ans="error";
			}
			echo $ans;
		}
	}

	   
	public function brandActDeact()
	{
		if(check_logged_in())
		{
			$this->check_access();
			
			$rid = trim($this->input->post('rid'));
			$sid = trim($this->input->post('sid'));
			
			if($rid!=""){
				$this->db->where('id', $rid);
				$this->db->update('master_asset_brand', array('is_active' => $sid));
				$ans="done";
			}else{
				$ans="error";
			}
			echo $ans;
		}
	}


	public function checkAvailablity(){

		$pro_id = trim($this->input->post('pid'));
		$cat_id = trim($this->input->post('cat_id'));
		$ram_id = trim($this->input->post('ram_id'));
		$processor_id = trim($this->input->post('processor_id'));
		$display_id = trim($this->input->post('display_id'));
		$hdd_id = trim($this->input->post('hdd_id'));
		$quant = trim($this->input->post('quant'));



		$qSql="SELECT * FROM asset_stock where product_category_id=".$cat_id."";
		if(!$quant== "") $qSql.=" and quantity > ".--$quant."";
		if(!$pro_id== "") $qSql.=" and product_id=".$pro_id."";
		if(!$processor_id== "") $qSql.=" and processor=".$processor_id."";
		if(!$hdd_id== "") $qSql.=" and hard_disk=".$hdd_id."";
		if(!$display_id== "") $qSql.=" and display=".$display_id."";
		if(!$ram_id== "") $qSql.=" and ram=".$ram_id."";

		$query = $this->db->query($qSql);
		$data = $query->num_rows();
		if($data > 0){
			$ans = array('status' => "done");
		}else{
			$ans = array('status' => "error");
		}
		echo json_encode($ans);
	}


	public function add_reqGdgt()
	{
		if(check_logged_in())
		{
			$current_loc = get_user_office_id();
			$current_user = get_user_fusion_id();
			$date = date('Y-m-d');
			$name = trim($this->input->post('pro_id'));
			$cat_id = trim($this->input->post('cat_id'));
			$brand_id = trim($this->input->post('brand_id'));
			$ram_id = trim($this->input->post('ram_id'));
			$processor_id = trim($this->input->post('processor_id'));
			$display_id = trim($this->input->post('display_id'));
			$hdd_id = trim($this->input->post('hdd_id'));
			$desc = trim($this->input->post('desc'));
			$quant = trim($this->input->post('quant'));

			$log=get_logs();
			
			if($name!=""){
				
				$field_array = array(
					"request_type" => 2,
					"product_id" => $name,
					"product_category_id" => $cat_id,
					"ram" => $ram_id,
					"display" => $display_id,
					"hard_disk" => $hdd_id,
					"processor" => $processor_id,
					"product_description" => $desc,
					"requested_by" => $current_user,
					"request_date" => $date,
					"quantity" => $quant,
					"location" => $current_loc,
					"status" => 1,
					"log" => $log
				);
				$rowid= data_inserter('asset_request',$field_array);
							
				$ans="done";
			}else{
				$ans="error";
			}
			
			echo $ans;
		}
	}


	public function purchse_requests($id){
		if(check_logged_in())
        {
			$current_user = get_user_fusion_id();
			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$data["aside_template"] = $this->aside;

			$qSql="SELECT r.*,ofc.location as loc,c.name as cat,h.size as hdd,mp.processor as pro,mr.size as ram_size,p.name as prod,ms.size as disp FROM asset_request as r left join master_asset_category as c on c.id = r.product_category_id left join master_asset_minimun_hard_disk_drive as h on h.id = r.hard_disk left join master_asset_minimun_processor as mp on mp.id = r.processor left join master_asset_minimun_ram as mr on mr.id = r.ram left join master_asset_products as p on p.id = r.product_id left join master_asset_system_screen_size as ms on ms.id = r.display left join office_location as ofc on ofc.abbr = r.location where request_type = 1";
			if($id != 1)$qSql .= " and requested_by = '".$current_user."'";
			$data['req_list'] = $this->Common_model->get_query_result_array($qSql);

			if($id == 1){
				$data["content_template"] = "asset/purchse_request.php";
			}else{
				$qSqlcat="SELECT * FROM master_asset_category where is_active=1";
				$data['cat_list'] = $this->Common_model->get_query_result_array($qSqlcat);

				$qSqlprod="SELECT * FROM master_asset_products where is_active=1";
				$data['pro_list'] = $this->Common_model->get_query_result_array($qSqlprod);

				$qSqlbrand="SELECT * FROM master_asset_brand where is_active=1";
				$data['brand_list'] = $this->Common_model->get_query_result_array($qSqlbrand);

				$qSqlprocessor="SELECT * FROM master_asset_minimun_processor where is_active=1";
				$data['processor_list'] = $this->Common_model->get_query_result_array($qSqlprocessor);

				$qSqlhdd="SELECT * FROM master_asset_minimun_hard_disk_drive where is_active=1";
				$data['hdd_list'] = $this->Common_model->get_query_result_array($qSqlhdd);

				$qSqlram="SELECT * FROM master_asset_minimun_ram where is_active=1";
				$data['ram_list'] = $this->Common_model->get_query_result_array($qSqlram);

				$qSqldisplay="SELECT * FROM master_asset_system_screen_size where is_active=1";
				$data['display_list'] = $this->Common_model->get_query_result_array($qSqldisplay);
				$data["content_template"] = "asset/show_purchse_requests.php";
			}
			
            $data["content_js"] = "asset_js.php";
            $data["error"] = ''; 	


			
			$this->load->view('dashboard',$data);
								
        }
	}

	
}

?>