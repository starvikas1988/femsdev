<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
//error_reporting(0);

include_once APPPATH.'/third_party/FormulaParser.php';
use FormulaParser\FormulaParser;

class F_parser {

    public $parser;
	public $formula;
   
    public function __construct($formula = "")
    {
		$CI = & get_instance();
		$this->formula = $formula;
		$this->parser = new FormulaParser($formula);
		
    }
	
	public function SetFormula($input_string){
	   $CI = & get_instance();
	   $this->parser = new FormulaParser($input_string);
       $this->formula = $input_string;
    }
	
	
}
