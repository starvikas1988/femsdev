<?php 

/* 
Author: Lawrrence Gandhar
Module : 

*/
defined('BASEPATH') OR exit('No direct script access allowed');
require_once '/opt/lampp/htdocs/femsdev/application/third_party/tcpdf/tcpdf.php';


class MyPDF extends TCPDF{
    
    //Page header
    public function Header1() {
        // Logo
        // Image method signature:
        // Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false)

        $image_file = '/opt/lampp/htdocs/oav/images/verso_logo.jpg';
        $this->Image($image_file, 10, 10, 50, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('helvetica', 'B', 10);
        // Title
        //Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=0, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='M')
		$html = '<h2 align="center"><u>INTERVIEW ASSESMENT FORM</u></h2>';
		$this->writeHTMLCell(0, 0, 0, '', $html, 0, 0, 0, true, 'L');
        /* $this->Cell(0, 4, 'Verso Group (UK) Limited', 1, false, 'R', 0, '', 0, false, 'M', 'M');
        $this->Ln(8);
        $this->Cell(181, 5, 'Suite 140, Westlink House ', 1, false, 'R', 0, '', 0, false, 'M', 'M');
        $this->Ln(8);
        $this->Cell(172, 5, '981 Great West Road', 1, false, 'R', 0, '', 0, false, 'M', 'M');
        $this->Ln(8);
        $this->Cell(170, 5, 'Brentford, TW8 9DN', 1, false, 'R', 0, '', 0, false, 'M', 'M');
        $this->Ln(8);*/
		$html = '<table  align="center" style="">
  <tr>
    <th>Excellent</th>
    <th>Good</th>
	<th>Average</th>
	<th>Unacceptable</th>
  </tr>
  <tr style="border: 1px solid black">
    <td style="border: 1px solid black" align="center">A</td>
    <td  style="border: 1px solid black" align="center">B</td>
	<td style="border: 1px solid black" align="center">C</td>
	<td style="border: 1px solid black" align="center">D</td>
  </tr>
  
  <tr style="border: 1px solid black">
    <td style="border: 1px solid black" align="center">A</td>
    <td  style="border: 1px solid black" align="center">B</td>
	<td style="border: 1px solid black" align="center">C</td>
	<td style="border: 1px solid black" align="center">D</td>
  </tr>
  
  
</table>';
		$this->writeHTMLCell(0, 0, 20, 20, $html, 0, 0, 0, true, 'L');
        //$this->Cell(12, 5, , 1, false, 'L', 0, '', 0, false, 'M', 'M');
        //$this->Cell(157, 5, 'TEL: 01582 763 090', 1, false, 'R', 0, '', 0, false, 'M', 'M');
    }

    function Header2(){
        $image_file = '/opt/lampp/htdocs/oav/images/verso_logo.jpg';
        $this->Image($image_file, 10, 10, 50, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
    }

    function Header(){
        if($this->page==1){
            $this->Header1();
        }else{
            $this->Header2();
        }
    }

    //Page header
    public function Footer() {
	
		/* if($this->page==1){
			$this->SetY(-15);
			$this->SetFont('helvetica', 'B', 10);
			$this->Cell(0, 10, 'Registered in England and Wales number: 7484788. VAT Number: GB 105 7241 44', 0, false, 'C', 0, '', 0, false, 'T', 'M');        
		}
		else if($this->page==2)
		{
			$this->SetY(-15);
			$this->SetFont('helvetica', 'B', 10);
			$this->Cell(0, 10, 'Registered in England and Wales number: 7484788. VAT Number: GB 105 7241 44', 0, false, 'C', 0, '', 0, false, 'T', 'M');
		} */
    }
}


class Createpdf extends CI_Controller
{

    public function index()
    {
        $form_data = $this->input->post('a');
		 
			
        $this->create_pdf($form_data);
      
    }
    public function create_pdf($form_data)
    {
        
		
        $pdf = new MyPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        
        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Verso');
        $pdf->SetTitle('Invoice');
        $pdf->SetSubject('Verso - Invoice');
        $pdf->SetKeywords('Verso, Invoice');

        // set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        // ---------------------------------------------------------

        // set default font subsetting mode
        $pdf->setFontSubsetting(true);

        // Set font
        // dejavusans is a UTF-8 Unicode font, if you only need to
        // print standard ASCII chars, you can use core fonts like
        // helvetica or times to reduce file size.
        $pdf->SetFont('dejavusans', '', 12, '', true);

        // Add Main page
        $pdf->AddPage();

        // set text shadow effect
        //$pdf->setTextShadow(array('enabled'=>false, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

        $pdf->Ln(20);
        $html = $form_data ;
        
		
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
 
        // ---------------------------------------------------------

        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.
        //$pdf->Output($form_data['order_id'].'.pdf', 'E');

        $pdf_string = $pdf->Output('dddddddddd');
        file_put_contents(APPPATH.'../uploads/VGL.pdf', $pdf_string);

        //============================================================+
        // END OF FILE
        //============================================================+
    }

   
	
	public function create_html(){
		
		
		
		
	}
	
	
	
}




