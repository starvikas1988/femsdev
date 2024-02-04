<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profilepic extends CI_Controller {
    
    /////////////////////////////////////////////////////////////////////////////////////////////
    // INDEX PAGE
    /////////////////////////////////////////////////////////////////////////////////////////////
    
	 function __construct() {
		parent::__construct();
		
		$this->load->model('Common_model');
		$this->load->model('user_model');
		$this->load->model('Profile_model');
		
	 }
	 
    public function index()
    {
		if(check_logged_in())
        {
			switch($this->input->post('action')) {
			  case 'save' :
				$this->saveAvatarTmp();
			  break;
			  default:
				$this->changeAvatar();
			 }
		}
    }
	
	 function changeAvatar() {
		 
        $post = isset($_POST) ? $_POST: array();
        $max_width = "500"; 
		$fusion_id = trim($this->input->post('profile-id'));
        $path = 'pimgs/'.$fusion_id;
		
		if (!file_exists($path)) {
			mkdir($path,0777, true);
		}
			
		
        $valid_formats = array("jpg", "png", "gif", "bmp","jpeg");
        $name = $_FILES['photoimg']['name'];
        $size = $_FILES['photoimg']['size'];
        if(strlen($name))
        {
			list($txt, $ext) = explode(".", $name);
			if(in_array($ext,$valid_formats))
			{
				if($size<(1024*1024)) // Image size max 1 MB
				{
					$actual_image_name = $fusion_id .'.'.$ext;
					
					$filePath = $path .'/'.$actual_image_name;
					$tmp = $_FILES['photoimg']['tmp_name'];
					
					if(move_uploaded_file($tmp, $filePath))
					{
						$width = $this->getWidth($filePath);
						$height = $this->getHeight($filePath);
						//Scale the image if it is greater than the width set above
						if ($width > $max_width){
							$scale = $max_width/$width;
							$uploaded = $this->resizeImage($filePath,$width,$height,$scale);
						}else{
							$scale = 1;
							$uploaded = $this->resizeImage($filePath,$width,$height,$scale);
						}
						
							$Update_array = array(
									"pic_ext" => $ext
							);
							
							$this->db->where('fusion_id', $fusion_id);
							$this->db->update('signin', $Update_array);	
							
						echo "<img id='photo' file-name='".$actual_image_name."' class='' src='".base_url().$filePath."?".time()."' class='preview'/>";
					
					}else echo "Failed";
				}
				else echo "Fail Image file size max 1 MB"; 
			}
			else echo "Fail Invalid file format.."; 
        }
        else echo "Please select image..!";
       
		///echo $filePath;
    }
    /*********************************************************************
     Purpose            : update image.
     Parameters         : null
     Returns            : integer
     ***********************************************************************/
     function saveAvatarTmp() {
		 
        
		$fusion_id = trim($this->input->post('pid'));
		$t = trim($this->input->post('t'));
		$image_name=trim($this->input->post('image_name'));
		$w1=trim($this->input->post('w1'));
		$h1=trim($this->input->post('h1'));
		$x1=trim($this->input->post('x1'));
		$y1=trim($this->input->post('y1'));
		
		$x2=trim($this->input->post('x2'));
		$y2=trim($this->input->post('y2'));
									
        $path = 'pimgs/'.$fusion_id;
		
        $t_width = 300; // Maximum thumbnail width
        $t_height = 300;    // Maximum thumbnail height
		
    if($t=="ajax")
    {
        
        $imagePath = $path."/".$image_name;
				
        $ratio = ($t_width/$w1); 
        $nw = ceil($w1 * $ratio);
        $nh = ceil($h1 * $ratio);
        $nimg = imagecreatetruecolor($nw,$nh);
        $im_src = imagecreatefromjpeg($imagePath);
        imagecopyresampled($nimg,$im_src,0,0,$x1,$y1,$nw,$nh,$w1,$h1);
        imagejpeg($nimg,$imagePath,90);
        
    }
    echo base_url().$imagePath.'?'.time();;	
    }
    
    /*********************************************************************
     Purpose            : resize image.
     Parameters         : null
     Returns            : image
     ***********************************************************************/
    function resizeImage($image,$width,$height,$scale) {
    $newImageWidth = ceil($width * $scale);
    $newImageHeight = ceil($height * $scale);
    $newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
    $source = imagecreatefromjpeg($image);
    imagecopyresampled($newImage,$source,0,0,0,0,$newImageWidth,$newImageHeight,$width,$height);
    imagejpeg($newImage,$image,90);
    chmod($image, 0777);
    return $image;
}
/*********************************************************************
     Purpose            : get image height.
     Parameters         : null
     Returns            : height
     ***********************************************************************/
function getHeight($image) {
    $sizes = getimagesize($image);
    $height = $sizes[1];
    return $height;
}
/*********************************************************************
     Purpose            : get image width.
     Parameters         : null
     Returns            : width
     ***********************************************************************/
function getWidth($image) {
    $sizes = getimagesize($image);
    $width = $sizes[0];
    return $width;
}
	
	
	
}

?>