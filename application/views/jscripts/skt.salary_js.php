<script type="text/javascript">

		
	function get_basic(gross,location,org_role)
	{
		
		var basic_amt = 0;
		var bsc_per = .52;
		// remove as per discuss  with arun from 2/11/2022
		//if (org_role == 13) bsc_per = .35;
		if (location == "CHA") bsc_per = .50;
		if (isIndiaLocation(location) == true) {
			basic_amt = Math.round(gross * bsc_per);
		} else {
			basic_amt = 0;
		}
		return basic_amt;
	}
	
	
	function get_hra(basic,location,org_role)
	{
		
		var hra_amt = 0;
		var hra_per = .50;
		
		// remove as per discuss  with arun from 2/11/2022
		//if (org_role == 13) hra_per = .75;
		//if (location == "CHA") gross_per = .25;

		if (isIndiaLocation(location) == true) {
			hra_amt = Math.round(basic * hra_per); 
		} else {
			hra_amt = 0;
		}
		
		return hra_amt;
	}
	
	
	function get_conveyance(gross,location, emp_type=3)
	{
		
		var conveyance = 0;
		
		
		if(location=="CHA") {
			
			var conv_per = .10;
			conveyance = Math.round(gross * conv_per);
			
		}else if (isIndiaLocation(location) == true){
			// if(emp_type==1 || emp_type==3) conveyance = 1600;
			// else conveyance = 800;
			
			// if(gross<7500) conveyance = 800;  

			//As per new structure comment the above on 17-10-2023//
			conveyance = 1600;
			
		} else {
			conveyance = 0;
		}
		
		return conveyance;
	}
	
	
		
	function get_gratuity_employer(basic, location)
	{
		var gratuity = 0;
		if(isIndiaLocation(location) == true){
			gratuity = Math.round(basic * .0481); 
		} else {
			gratuity = 0;
		}
		return gratuity;
	}
	
	
	
	
function get_lwf_employer(location,brand_id="")
{
	
	var lwfemper = 0;
	//WB
	// if (location == "DUR" || location == "HWH" || location == "KLY" || location == "KOL") lwfemper = 15;
	// else if (location == "BLR") lwfemper = 40;
	// else if (location == "CHA") lwfemper = 20;
	// else if (location == "CHE") lwfemper = 20;
	// else if (location == "JMP") lwfemper = 0;
	// else if (location == "KOC") lwfemper = 50;
	// else if (location == "MUM") lwfemper = 36;
	// else if (location == "NOI") lwfemper = 0;
	// else lwfemper = 0;
	
	//As per new salary annexture on 17-10-2023
	if (location == "DUR" || location == "HWH" || location == "KLY" || location == "KOL") {
		if(brand_id != '2' && brand_id != '3'){
			lwfemper = 15;
		}else{
			lwfemper = 0;
		}		
	}else if(location == "KOC"){
		lwfemper = 50;
	}else if(location == "CHA"){
		lwfemper = 20;
	}else{
		lwfemper = 0;
	}
	
	return lwfemper;
}

function get_lwf_employer_year(location,brand_id="")
{
	
	var lwfemper = 0;
	//WB
	// if (location == "DUR" || location == "HWH" || location == "KLY" || location == "KOL") lwfemper = 15*2; 
	// else if (location == "BLR") lwfemper = 40*1;
	// else if (location == "CHA") lwfemper = 20*12;
	// else if (location == "CHE") lwfemper = 20*1; // one type
	// else if (location == "JMP") lwfemper = 0;
	// else if (location == "KOC") lwfemper = 50*12;
	// else if (location == "MUM") lwfemper = 36*2;
	// else if (location == "NOI") lwfemper = 0;
	// else lwfemper = 0;

	//As per new salary annexture on 17-10-2023
	if (location == "DUR" || location == "HWH" || location == "KLY" || location == "KOL") {
		if(brand_id != '2' && brand_id != '3'){
			lwfemper = 15*2;
		}else{
			lwfemper = 0;
		}
	}else if(location == "KOC"){
		lwfemper = 50*12;
	}else if(location == "CHA"){
		lwfemper = 20*12;
	}else{
		lwfemper = 0;
	}
	
	return lwfemper;
}

function get_lwf_employee(location,brand_id="")
{
	
	var lwfemper = 0;
	//WB
	// if (location == "DUR" || location == "HWH" || location == "KLY" || location == "KOL") lwfemper = 3;
	// else if (location == "BLR") lwfemper = 20;
	// else if (location == "CHA") lwfemper = 5;
	// else if (location == "CHE") lwfemper = 10;
	// else if (location == "JMP") lwfemper = 0;
	// else if (location == "KOC") lwfemper = 50;
	// else if (location == "MUM") lwfemper = 12;
	// else if (location == "NOI") lwfemper = 0;
	// else lwfemper = 0;

	//As per new salary annexture on 17-10-2023
	if (location == "DUR" || location == "HWH" || location == "KLY" || location == "KOL") {
		if(brand_id != '2' && brand_id != '3'){
			lwfemper = 3;
		}else{
			lwfemper = 0;
		}
	}else if(location == "KOC"){
		lwfemper = 50;
	}else if(location == "CHA"){
		lwfemper = 5;
	}else{
		lwfemper = 0;
	}
	
	return lwfemper;
}


function get_lwf_employee_year(location,brand_id="")
{
	var lwfemper = 0;
	//WB
	// if (location == "DUR" || location == "HWH" || location == "KLY" || location == "KOL") lwfemper = 3*2;
	// else if (location == "BLR") lwfemper = 20*1;
	// else if (location == "CHA") lwfemper = 5*12;
	// else if (location == "CHE") lwfemper = 10*1;
	// else if (location == "JMP") lwfemper = 0;
	// else if (location == "KOC") lwfemper = 50*12;
	// else if (location == "MUM") lwfemper = 12*2;
	// else if (location == "NOI") lwfemper = 0;
	// else lwfemper = 0;

	//As per new salary annexture on 17-10-2023
	if (location == "DUR" || location == "HWH" || location == "KLY" || location == "KOL") {
		if(brand_id != '2' && brand_id != '3'){
			lwfemper = 3*2;
		}else{
			lwfemper = 0;
		}
	}else if(location == "KOC"){
		lwfemper = 50*12;
	}else if(location == "CHA"){
		lwfemper = 5*12;
	}else{
		lwfemper = 0;
	}
	
	return lwfemper;
}



function get_medical_allowance(gross, basic, hra, conveyance, bonus, location)
{
	var medical_amt = 0;
	var bonus = 0; //As per new structure comment on 17-10-2023//
	if (location == "CHA") {
		medical_amt = Math.round(gross - (basic + hra + conveyance + bonus));
				
	} else {
		medical_amt = 0;
	}
	return medical_amt;
}



function get_allowance(gross, basic, hra, conveyance, location)
{
	var allowance = 0;
	if (isIndiaLocation(location) == true) {
		allowance = Math.round( gross - (basic + hra + conveyance));
	} else {
		allowance = 0;
	}
	return allowance;
}

function get_ptax(gross, location, sex)
{
	if(sex=="") sex="male";
	sex = sex.toLowerCase();
	
	var ptax = 0;

	//wb
	if (gross > 10000 && gross <= 15000) ptax = 110;
	else if (gross > 15000 && gross <= 25000) ptax = 130;
	else if (gross > 25000 && gross <= 40000) ptax = 150;
	else if (gross > 40000) ptax = 200;

	if (location == "BLR") {
		ptax = 0;
		if (gross > 15000) ptax = 200;
	} else if (location == "NOI") {
		ptax = 0;
	} else if (location == "MUM") {
										
		ptax = 0;
		if (sex == "female") {
			if (gross >= 10001) ptax = 200;
		} else {
			if (gross >= 7501 && gross <= 10000) ptax = 175;
			else if (gross >= 10001) ptax = 200;
		}
	} else if (location == "CHE") {
		
		//IF(Gross Salary<=21000,0,IF(Gross Salary<=30000,135,IF(Gross Salary<=45000,315,IF(Gross Salary<=60000,690,IF(Gross Salary<=75000,1025,IF(Gross Salary>75000,1250))))))


		ptax = 0;
		// if (gross > 21000 && gross <= 30000) ptax = 135;
		// else if (gross > 30000 && gross <= 45000) ptax = 315;
		// else if (gross > 45000 && gross <= 60000) ptax = 690;
		// else if (gross > 60000 && gross <= 75000) ptax = 1025;
		// else if (gross > 75000) ptax = 1250;

		//As per new salary annexture on 17-10-2023
		if (gross > 3501 && gross <= 5000) ptax = 22.5;
		else if (gross > 5001 && gross <= 7500) ptax = 52.5;
		else if (gross > 7501 && gross <= 10000) ptax = 115;
		else if (gross > 10001 && gross <= 12500) ptax = 171;
		else if (gross > 12501) ptax = 208;
		
	} else if (location == "KOC") {
		
		//IF(C14<=11999,0,IF(C14<=17999,120,IF(C14<=29999,180,IF(C14<=44999,300,IF(C14<=59999,450,IF(C14<=74999,600,
		//IF(C14<=99999,750,IF(C14<=124999,1000,IF(C14>=125000,1250)))))))))
		
		ptax = 0;
		// gross = gross*6;
		
		// if (gross >= 12000 && gross < 18000) ptax = 120;
		// else if (gross >= 18000 && gross < 30000) ptax = 180;
		// else if (gross >= 30000 && gross < 45000) ptax = 300;
		// else if (gross >= 45000 && gross < 60000) ptax = 450;
		// else if (gross >= 60000 && gross < 75000) ptax = 600;
		// else if (gross >= 75000 && gross < 100000) ptax = 750;
		// else if (gross >= 100000 && gross < 125000) ptax = 1000;
		// else if (gross >= 125000) ptax = 1250;

		//As per new salary annexture on 17-10-2023
		if (gross > 1999 && gross < 2999) ptax = 20;
		else if (gross > 2999 && gross <= 4999) ptax = 30;
		else if (gross > 4999 && gross <= 7499) ptax = 50;
		else if (gross > 7499 && gross <= 9999) ptax = 75;
		else if (gross > 9999 && gross <= 12499) ptax = 100;
		else if (gross > 12499 && gross <= 16666) ptax = 125;
		else if (gross > 16666 && gross <= 20833) ptax = 166;
		else if (gross >= 20833) ptax = 208;
		
		//if(ptax > 0) ptax = Math.round(ptax/6);
		
		
	} else if (location == "JMP") {

		ptax = 0;
		
		/*
		if (gross > 25000 && gross <= 41666) ptax = 100;
		else if (gross > 41666 && gross <= 66666) ptax = 150;
		else if (gross > 66666 && gross <= 83333) ptax = 175;
		else if (gross > 83333) ptax = 208;
		*/

		//As per new salary annexture on 17-10-2023
		if (gross > 25000 && gross <= 41666) ptax = 100;
		else if (gross > 41666 && gross <= 66666) ptax = 150;
		else if (gross > 66666 && gross <= 83333) ptax = 175;
		else if (gross > 83333) ptax = 208;
		
	} else if (location == "CHA") {
		ptax = 0;
		//As per new salary annexture on 17-10-2023		
		//if (gross > 41001) ptax = 200;

		if (gross > 40000) ptax = 200;
	}

	return ptax;
}

function get_esi_employer(gr_amt_esi, location, gmt_calamount)
{	
	if (gmt_calamount == "") gmt_calamount = gr_amt_esi; 

	var esi_employer = 0;
	
	if (gr_amt_esi <= 21000) {
		if (isIndiaLocation(location) == true ) {
			
			esi_employer = Math.ceil(gmt_calamount * .0325);			
		} else {
			esi_employer = 0;
		}
	}
	
	return esi_employer;
}

function get_esi_employee(gr_amt_esi, location,  gmt_calamount)
{

	if (gmt_calamount == "") gmt_calamount = gr_amt_esi;

	var esi_employee = 0;
	if (gr_amt_esi <= 21000) {
		
		if (isIndiaLocation(location) == true ) {
			esi_employee = Math.ceil(gmt_calamount * .0075);
		} else {
			esi_employee = 0;
		}
	}
	return esi_employee;
}



// new logic for pan india from 02/11/2022
function get_pf_employer(basic, location)
{
	//IF(Basic>15000,ROUND(15000*12%,0)+ROUND(15000*0.5%,0)+ROUND(Basic*0.5%,0),  ROUND(Basic*13%,0))
	var pf = 0;
	//as per new salary annexture comment the above on 17-10-2023 and add code in below
	if (isIndiaLocation(location) == true) {
		if(location == 'CHA'){
			if(basic>15000) pf = Math.round(15000 *.12) + Math.round(15000 *.005) + Math.round(basic *.005);
			else  pf = Math.round(basic *.13);
		}else{
			if(basic>15000) pf = Math.round(15000 *.12);
			else  pf = Math.round(basic *.12);
		}	
		
	} else {
		pf = 0;
	}

	return pf;
}

// new logic for pan india from 02/11/2022
function get_pf_employee(basic, location)
{
	//IF(Basic>15000,ROUND(15000*12%,0), ROUND(Basic*12%,0) )
	var pf = 0;
	if (isIndiaLocation(location) == true) {
		
		if(location=="CHA"){
			 pf = Math.round(basic *.12);
		}else{
			if(basic>15000) pf = Math.round(15000 *.12);
			else  pf = Math.round(basic *.12);
		}
		
	} else {
		pf = 0;
	}
	return pf;
}





	
	
	
	

	
  
</script>

