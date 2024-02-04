<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * PDF Library
 * 
 */
//require_once(dirname(__FILE__) . '/dompdf/autoload.inc.php');
  require_once APPPATH.'third_party/dompdf/autoload.inc.php';	

use Dompdf\Dompdf;

class Pdf{
	
	public  function __construct(){
	
		//require_once dirname(__FILE__).'/dompdf/autoload.inc.php';
		require_once APPPATH.'third_party/dompdf/autoload.inc.php';	

		
			$pdf = new DOMPDF();
			$CI = & get_instance();
			$CI->dompdf = $pdf;
		}
	
		protected function ci()
		{
			
			return get_instance();
		}
		/**
		 * Load a CodeIgniter view into domPDF
		 *
		 * @access	public
		 * @param	string	$view The view to load
		 * @param	array	$data The view data
		 * @return	void
		 */
		 
		public function load_view($view, $data = array())
		{
			$dompdf = new Dompdf();
			$html = $this->ci()->load->view($view, $data, TRUE);

			$dompdf->loadHtml($html);

			// (Optional) Setup the paper size and orientation
			$dompdf->setPaper('A4', 'portrait');
			//$dompdf->setPaper('Legal', 'Landscape');
			// Render the HTML as PDF
			
			//$customPaper = array(0,0,360,360);
			//$dompdf->set_paper($customPaper);


			$dompdf->render();
			$time = time();

			// Output the generated PDF to Browser
			$dompdf->stream("Interview-". $time);
		}
	
	
}
?>


 