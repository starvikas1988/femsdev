<?php

$CI =& get_instance();

function get_basic($gross, $location,$org_role=0){
	
	$basic=0;
	$bsc_per=.52;
	if($org_role==13) $bsc_per=.35;
	if($location=="CHA") $bsc_per=.50;
	
	if(isIndiaLocation($location)== true){
		$basic = round($gross*$bsc_per);
	}else{
		$basic = 0;
	}			  
	return $basic;
	
}

function get_hra($basic, $location, $org_role=0){
	$hra = 0;
	$hra_per=.50;
	if($org_role==13) $hra_per=.75;
	
	if($location=="CHA") $bsc_per=.25;
	
	if(isIndiaLocation($location)== true){
		$hra = round($basic*$hra_per);
	}else{
		$hra = 0;
	}
	return $hra;
}

function get_conveyance($gross, $location){
	$conveyance = 0;
	if($location=="CHA"){
		$conv_per=.10;
		$conveyance =round($gross*$conv_per);
	}else if(isIndiaLocation($location)== true){
		$conveyance = 1600;
	}else{
		$conveyance = 0;
	}
	return $conveyance;
}


function get_bonus_cha($skill_set_slab, $location){
	$bonus = 0;
	$bonus_per=.0833;
	if($location=="CHA"){
		$bonus = round($skill_set_slab*$bonus_per);
	}else{
		$bonus = 0;
	}
	return $bonus;
}

function get_gratuity_employer_cha($basic, $location){
	$gratuity = 0;
	if($location=="CHA"){
		$gratuity = round($basic*.0481);
	}else{
		$gratuity = 0;
	}
	return $gratuity;
}



function get_medical_allowance($gross, $basic, $hra,$conveyance, $bonus, $location){
	$medical_amt = 0;
		 
	if($location=="CHA"){
		$medical_amt = round($gross - ($basic+$hra+$conveyance+$bonus));
	}else{
		$medical_amt = 0;
	}
	return $medical_amt;
}



function get_allowance($gross, $basic, $hra,$conveyance, $location){
	$allowance = 0;
	if(isIndiaLocation($location)== true){
		$allowance = $gross - ($basic+$hra+$conveyance);
	}else{
		$allowance = 0;
	}
	return $allowance;
}

function get_ptax($gross, $location, $sex="Male"){
	$ptax=0;
	
	if($location =="KOL" || $location=="HWH" ){
		$ptax = 0;
		
		if( $gross > 10000 && $gross <= 15000 ) $ptax = 110;
		else if($gross > 15000 && $gross <= 25000) $ptax = 130;
		else if($gross > 25000 && $gross <= 40000) $ptax = 150;
		else if($gross > 40000) $ptax = 200;
		
	}else if($location=="BLR"){
		$ptax = 0;
		if($gross>15000) $ptax = 200;
	}else if($location=="NOI"){
		$ptax = 0;
	}else if($location=="MUM"){
		$ptax = 0;
		if(strtoupper($sex =="FEMALE")){
			if($gross >= 10001) $ptax = 200;
		}else{
			if($gross >= 7501 && $gross <= 10000) $ptax = 175;
			else if($gross >= 10001) $ptax = 200;
		}
		
	}else if($location=="CHE"){
		$ptax = 0;
		if( $gross > 3500 && $gross <= 5000 ) $ptax = 22.50;
		else if($gross > 5000 && $gross <= 7500) $ptax = 52.50;
		else if($gross > 7500 && $gross <= 10000) $ptax = 115;
		else if($gross > 10000 && $gross <= 12500) $ptax = 171;
		else if($gross > 12500) $ptax = 208;
	
	}else if($location=="KOC"){
		$ptax = 0;
		if( $gross >= 2000 && $gross < 3000 ) $ptax = 20;
		else if($gross >= 3000 && $gross < 5000) $ptax = 30;
		else if($gross >= 5000 && $gross < 7500) $ptax = 50;
		else if($gross >= 7500 && $gross < 10000) $ptax = 75;
		else if($gross >= 10000 && $gross < 12500) $ptax = 100;
		else if($gross >= 12500 && $gross < 16667) $ptax = 125;
		else if($gross >= 16667 && $gross < 20833) $ptax = 166;
		else if($gross >= 20833) $ptax = 208;
	
	}else if($location=="CHA"){
		$ptax = 0;
		if($gross>45000) $ptax = 200;
	}else{
		$ptax = 0;
	}
				
	return $ptax;
	
}

function get_esi_employer($gr_amt_esi, $location){
	
	$esi_employer=0;
	if($gr_amt_esi<=21000){
		if(isIndiaLocation($location)== true || $location=="CHA" ){
			$esi_employer = round($gr_amt_esi * .0325);
		}else{
			$esi_employer = 0;
		}
	}
	return $esi_employer;
}

function get_esi_employee($gr_amt_esi, $location){
	
		
	$esi_employee=0;
	if($gr_amt_esi<=21000){
		if(isIndiaLocation($location)== true || $location=="CHA"){
			$esi_employee = round($gr_amt_esi * .0075);
		}else{
			$esi_employee = 0;
		}
	}
	return $esi_employee;	
}

function get_pf($basic, $location){
	
	$pf=0;
	if(isIndiaLocation($location)== true){
		
		$pf = round($basic * .12);
		if($pf > 1800) $pf = 1800;
		
	}else{
		$pf = 0;
	}
	return $pf;	
}


function get_pf_employees_cha($basic, $location){
	
	$pf=0;
	if($location=="CHA" ){
		$pf = round($basic * .12);
		//if($pf > 1950) $pf = 1950;
	}else{
		$pf = 0;
	}
	return $pf;	
}

function get_pf_employer_cha($basic, $location){
	
	$pf=0;
	if($location=="CHA" ){
		$pf = round($basic * .13);
		if($pf > 1950) $pf = 1950;
	}else{
		$pf = 0;
	}
	return $pf;	
}


/////////////////// Start India Calculate Number in words /////////////////////////////
	function numberTowords($num)
	{
		$ones = array(
		0 =>"ZERO",
		1 => "ONE",
		2 => "TWO",
		3 => "THREE",
		4 => "FOUR",
		5 => "FIVE",
		6 => "SIX",
		7 => "SEVEN",
		8 => "EIGHT",
		9 => "NINE",
		10 => "TEN",
		11 => "ELEVEN",
		12 => "TWELVE",
		13 => "THIRTEEN",
		14 => "FOURTEEN",
		15 => "FIFTEEN",
		16 => "SIXTEEN",
		17 => "SEVENTEEN",
		18 => "EIGHTEEN",
		19 => "NINETEEN",
		"014" => "FOURTEEN"
		);
		$tens = array( 
		0 => "ZERO",
		1 => "TEN",
		2 => "TWENTY",
		3 => "THIRTY", 
		4 => "FORTY", 
		5 => "FIFTY", 
		6 => "SIXTY", 
		7 => "SEVENTY", 
		8 => "EIGHTY", 
		9 => "NINETY" 
		); 
		$hundreds = array( 
		"HUNDRED", 
		"THOUSAND", 
		"MILLION", 
		"BILLION", 
		"TRILLION", 
		"QUARDRILLION" 
		); /*limit t quadrillion */
		$num = number_format($num,2,".",","); 
		$num_arr = explode(".",$num); 
		$wholenum = $num_arr[0]; 
		$decnum = $num_arr[1]; 
		$whole_arr = array_reverse(explode(",",$wholenum)); 
		krsort($whole_arr,1); 
		$rettxt = ""; 
		foreach($whole_arr as $key => $i){			
			while(substr($i,0,1)=="0")
					$i=substr($i,1,5);
			if($i < 20){ 
			/* echo "getting:".$i; */
			$rettxt .= $ones[$i]; 
			}elseif($i < 100){ 
				if(substr($i,0,1)!="0")  $rettxt .= $tens[substr($i,0,1)]; 
				if(substr($i,1,1)!="0") $rettxt .= " ".$ones[substr($i,1,1)]; 
			}else{ 
				if(substr($i,0,1)!="0") $rettxt .= $ones[substr($i,0,1)]." ".$hundreds[0]; 
				if(substr($i,1,1)!="0")$rettxt .= " ".$tens[substr($i,1,1)]; 
				if(substr($i,2,1)!="0")$rettxt .= " ".$ones[substr($i,2,1)]; 
			} 
			if($key > 0){ 
				$rettxt .= " ".$hundreds[$key]." "; 
			}
		} 
		if($decnum > 0){
			$rettxt .= " and ";
			if($decnum < 20){
				$rettxt .= $ones[$decnum];
				}elseif($decnum < 100){
					$rettxt .= $tens[substr($decnum,0,1)];
					$rettxt .= " ".$ones[substr($decnum,1,1)];
			}
		}
		return $rettxt;
	}
	
	///////////////////// End Calculate Number in words /////////////////////////////
	/////////////////// Start India Calculate Number in words /////////////////////////////
	function getIndianCurrency(float $number)
	{ 
		$decimal = round($number - ($no = floor($number)), 2) * 100;
		$hundred = null;
		$digits_length = strlen($no);
		$i = 0;
		$str = array();
		$words = array(0 => '', 1 => 'One', 2 => 'Two',
			3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
			7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
			10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
			13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
			16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
			19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
			40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
			70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety');
		$digits = array('', 'Hundred','Thousand','Lakh', 'Crore');
		while( $i < $digits_length ) {
			$divider = ($i == 2) ? 10 : 100;
			$number = floor($no % $divider);
			$no = floor($no / $divider);
			$i += $divider == 10 ? 1 : 2;
			if ($number) {
				$plural = (($counter = count($str)) && $number > 9) ? 's' : null;
				$hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
				$str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
			} else $str[] = null;
		}
		$Rupees = implode('', array_reverse($str));
		$paise = ($decimal > 0) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '' . " Only ";
		return ($Rupees ? 'Rupees: '. $Rupees  : '') . $paise;
	}
	///////////////////// End Calculate Number in words /////////////////////////////


