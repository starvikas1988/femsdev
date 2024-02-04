<?php
	$approved_on = $can_dtl_row['approved_on'];
	if($approved_on=="") $approved_on=date("d/m/Y");
	
	$gross_pay = $can_dtl_row['gross_pay'];
	$location = $can_dtl_row['location'];
	$org_role = $can_dtl_row['org_role'];
	$pay_type= $can_dtl_row['pay_type'];
	$gender = $can_dtl_row['gender'];
	$incentive_amt = $can_dtl_row['incentive_amt'];
	$incentive_period = $can_dtl_row['incentive_period'];
	$joining_bonus = $can_dtl_row['joining_bonus'];
	$variable_pay=$can_dtl_row['variable_pay'];
	$skill_set_slab = $can_dtl_row['skill_set_slab'];
	if($skill_set_slab=="") $skill_set_slab=0;
	
	$training_fees = $can_dtl_row['training_fees'];
	if($training_fees=="") $training_fees=0;
	
	if($location=="") $location = $can_dtl_row['pool_location'];
		
	$basic = get_basic($gross_pay, "CHA", $org_role);
	$hra =  get_hra($basic, "CHA", $org_role);
	
	$conveyance = get_conveyance($gross_pay, "CHA");
	$bonus = get_bonus_cha($skill_set_slab, "CHA");
	$gratuity_employer = get_gratuity_employer_cha($basic, "CHA");
	$medical_allowance = get_medical_allowance($gross_pay, $basic, $hra, $conveyance, $bonus, $location);
	
	$ptax = get_ptax($gross_pay, $location, $gender);
	
	$pf_employee = get_pf_employees_cha($basic, "CHA");
	$pf_employer = get_pf_employer_cha($basic, "CHA");
	
	$gr_amt_esi =  $gross_pay - $conveyance;
		
	$esi_employer = get_esi_employer($gr_amt_esi, "CHA", $gross_pay);
	$esi_employee = get_esi_employee($gr_amt_esi, "CHA", $gross_pay);
	
	$lwf_employers = 0;
	$lwf_employees = 0;
	
	if($location=="CHA"){
		$lwf_employers = 20;
		$lwf_employees = 5;
	}
	
	if($pay_type=="8"){
		$pf_employee=0;
		$pf_employer=0;
		$esi_employer=0;
		$esi_employee=0;
	}
	
	
	$employee_deduc = round($pf_employee + $esi_employee + $ptax + $lwf_employees);
	$employer_contri = round($esi_employer + $pf_employer + $gratuity_employer + $lwf_employers);
	
	$ctc = round($gross_pay + $esi_employer + $pf_employer + $gratuity_employer + $lwf_employers);
	
	$tk_home = round($gross_pay - ($pf_employee + $esi_employee + $ptax + $lwf_employees));
	
	if($org_role==13) $notice_period='30';
	else $notice_period='90';
	
?>
			
<div style="margin:5px;">	
	
	
	<div id="body1" style='width:100%;'>
		<br/><br/><br/>
		<P style='text-align:right;'>Date: <?php echo $approved_on; ?></P>
		
		<strong>Name:</strong> <?php echo $can_dtl_row['fname'].' '.$can_dtl_row['lname'] ?>
		<br>
		Address: <?php echo $can_dtl_row['address'];?>	
		<P style='font-size:15px; text-align:center; font-weight:bold;'>Re: Letter of Offer</P>
		<span>Dear <?php echo $can_dtl_row['fname'].' '.$can_dtl_row['lname'] ?>,</span>
		<br>
		<br>
		<span> This is in the reference to our discussion and interview had with you, we are pleased to offer you employment with Competent Synergies Pvt. Ltd. on the following terms and conditions:</span>
		<br><br>
		<span>1. You will be designated as <b><?php echo $can_dtl_row['position_name'];?></b> , <b><?php echo $can_dtl_row['department_name'];?></b> (Designation & Department).</span><br>
		<span>2. Your monthly Gross salary will be <strong>Rs. <?php echo $can_dtl_row['gross_pay'];?>/- ( <?php echo getIndianCurrency($can_dtl_row['gross_pay']); ?></strong> <strong>)</strong>.</span><br>
		<?php if($incentive_amt > 0 || $joining_bonus > 0){ ?>
			<span> &nbsp;&nbsp; Additional  Remuneration:</span>
			<span> &nbsp;<?php if($incentive_amt > 0) echo "$incentive_period Incentive Amount: Rs. $incentive_amt "; if($joining_bonus > 0) echo " &nbsp; Joining Bonus: Rs. $joining_bonus"; ?></span><br>
		<?php } ?>
		<?php if($variable_pay > 0 ){ ?>                          
			<span> &nbsp;&nbsp; Variable Pay:</span>
                        <span> &nbsp;Rs.<?php echo $variable_pay; ?></span><br><br>
		<?php } ?>
		<span>3. You will be based at one of our location at <?php echo $can_dtl_row['location_name'];?></span><br>
		<span>4. Your date of joining will be on or before <?php echo $can_dtl_row['doj'] .", " . date('d/m/Y',strtotime($can_dtl_row['doj']));?></span><br>
		<span>5. Your employment would be subject to a positive Reference Check.  </span><br>
		<span>6. Your appointment letter along with employment terms & conditions will be issued to you at the time of your joining. </span><br>
		<span>7. Please bring the below listed documents/details on your day of joining. </span><br>
		<span> &nbsp;&nbsp; a) Date of Birth proof certificate (Copy of Passport/Birth certificate/Matriculation certificate)</span><br>
		<span> &nbsp;&nbsp; b) Academic certificates & Relieving Letter/Resignation acceptance letter from previous employer.</span><br>
		<span> &nbsp;&nbsp; c) Proof of compensation-Salary Slip/Appointment Letter/Appraisal letter of previous employment</span><br>
		<span> &nbsp;&nbsp; d) Three passport size photographs</span><br>
		<span> &nbsp;&nbsp; e) Identity & Residence proof: Pan Card/Passport/Driving License/Ration Card/Voter Card/ Aadhar Card</span>
		<br><br>
		<span>Kindly sign the duplicate copy of this letter as a token of your acceptance.</span><br><br>
		<span>Looking forward to a long and mutually beneficial association with us!</span>
		<br><br>
		<span>Congratulations and best wishes,</span>
		<br/>
		<table cellpadding='0' cellspacing="0" border='0' align='center' style='font-weight:bold; width:100%;'>
		<tr >
			<td style="height:30px;">For Competent Synergies Private Limited.</td>
			<td style="height:30px;">I hereby accept the above offer<br/></td>
		</tr>
		<tr >
			<td style="height:80px;">
			<!--<img height='80px' src="<?php APPPATH ?>main_img/stamp_cspl.jpg" alt="signature" />-->
			<img height='50px' src="<?php APPPATH ?>main_img/cha_hr_arun_kumar_mishra_signature.png" alt="signature" />
			<br/></td>
			<td style="height:80px;">Signature:......................................................<br/><br/></td>
		</tr>
		<tr>
			<td style="height:30px;">
				Arun Kumar Mishra<br> Assistant General Manager-Human Resources
			</td>
			<td style="height:30px;">Name:.............................................................</td>
		</tr>
		</table>
		<br/>
		
		
		<div style="page-break-after: always"><span style="display: none;">&nbsp;</span></div>
		<br><br><br><br>
		
		<table cellpadding='2' cellspacing="0" border='1' align='center' style='font-size:12px; text-align:center; width:99%;'>
		<tr>
			<td style="text-align:left;" >Name</td>
			<td><?php echo $can_dtl_row['fname'].' '.$can_dtl_row['lname'] ?></td>	
		</tr>
		<tr>
			<td style="text-align:left;" >Designation</td>
			<td> <?php echo $can_dtl_row['position_name'];?> </td>	
		</tr>
		<tr>
			<td style="text-align:left;" >Department</td>
			<td> <?php echo $can_dtl_row['department_name'];?> </td>	
		</tr>
		</table>
		<P style='text-align:center;font-size:16px'><strong>ANNEXURE-1</P>		 
		<table cellpadding='2' cellspacing="0" border='1' align='center' style='font-size:12px; text-align:center; width:99%;'>
		
			<tr bgcolor="#A9A9A9">
				<th style="width:50%; text-align:left;"><strong>Salary Components</strong></th>
				<th><strong>Monthly</strong></th>
				<th><strong>Yearly</strong></th>		
			</tr>
			<tr>
	<tr>
		<td style="text-align:left;" >Basic</td>
		<td><?php echo $basic; ?></td>
		<td><?php echo ($basic*12); ?></td>		
	</tr>
	<tr>
		<td style="text-align:left;" >House Rent Allowance</td>
		<td><?php echo $hra; ?></td>
		<td><?php echo ($hra*12); ?></td>		
	</tr>
	<tr>
		<td style="text-align:left;" >Conveyance Allowance</td>
		<td><?php echo $conveyance; ?></td>
		<td><?php echo ($conveyance*12); ?></td>		
	</tr>
	<tr>
		<td style="text-align:left;" >Medical Allowance</td>
		<td><?php echo $medical_allowance; ?></td>
		<td><?php echo ($medical_allowance*12); ?></td>		
	</tr>
			
	<tr>
		<td style="text-align:left;" >Statutory Bonus</td>
		<td><?php echo $bonus; ?></td>
		<td><?php echo ($bonus*12); ?></td>		
	</tr>
	<tr bgcolor="#D3D3D3" >
		<td style="text-align:left;" >Gross Salary (A)</td>
		<td><?php echo $gross_pay; ?></td>
		<td><?php echo ($gross_pay*12); ?></td>		
	</tr>
	
	<tr>
		<td style="text-align:left;" >Employer PF-@ 13% of Basic  *</td>
		<td><?php echo $pf_employer; ?></td>
		<td><?php echo ($pf_employer*12); ?></td>
	</tr>
	<tr >
		<td style="text-align:left;" >Employer ESI-@3.25% of Gross Salary *</td>
		<td><?php echo $esi_employer; ?></td>
		<td><?php echo ($esi_employer*12); ?></td>		
	</tr>
	<tr >
		<td style="text-align:left;" >Gratuity *</td>
		<td><?php echo $gratuity_employer; ?></td>
		<td><?php echo ($gratuity_employer*12); ?></td>		
	</tr>
	<tr style="text-align:left;">
		<td style="text-align:left;" >Employer Labour Welfare Fund *</td>
		<td><?php echo $lwf_employers; ?></td>
		<td><?php echo ($lwf_employers*12); ?></td>		
	</tr>
	<tr bgcolor="#D3D3D3" >
		<td style="text-align:left;" >Employer Contribution (B)</td>
		<td><?php echo $employer_contri; ?></td>
		<td><?php echo ($employer_contri*12); ?></td>		
	</tr>
	<tr>
		<td style="text-align:left;" >Employee PF- @ 12% Of Basic*</td>
		<td><?php echo $pf_employee; ?></td>
		<td><?php echo ($pf_employee*12); ?></td>
	</tr>
	<tr>
		<td style="text-align:left;" >Employee ESI- @ 0.75% of Gross Salary *</td>
		<td><?php echo $esi_employee; ?></td>
		<td><?php echo ($esi_employee*12); ?></td>
	</tr>
	
		
	<tr>
		<td style="text-align:left;" >Employee Labour Welfare Fund * </td>
		<td><?php echo $lwf_employees; ?></td>
		<td><?php echo ($lwf_employees*12); ?></td>
	</tr>
	<tr>
		<td style="text-align:left;" >Professional Tax Deduction * </td>
		<td><?php echo $ptax; ?></td>
		<td><?php echo ($ptax*12); ?></td>
	</tr>
	<tr bgcolor="#D3D3D3">
		<td style="text-align:left;" >Employee Deduction (C )</td>
		<td><?php echo $employee_deduc; ?></td>
		<td><?php echo ($employee_deduc*12); ?></td>
	</tr>
	<tr bgcolor="#D3D3D3">
		<td style="text-align:left;" >Cost to Company (A+B)</td>
		<td><?php echo $ctc; ?></td>
		<td><?php echo ($ctc*12); ?></td>
	</tr>
	<tr bgcolor="#D3D3D3">
		<td style="text-align:left;" >Take Home Salary (D) = (A - C)</td>
		<td><?php echo $tk_home; ?></td>
		<td><?php echo ($tk_home*12); ?></td>
	</tr>
	</table>	
	<br>
	
	<?php if($incentive_amt > 0){ ?>
		<span>Performance Linked Incentive : <?php echo "Rs. ".$incentive_amt . " " .$incentive_period; ?></span>
	<?php } ?>		
	<br><br>
	<span style='font-size:10px'>* As per provision of PF, ESI, Gratuity, LWF & Professional Tax Act</span><br>
	<span style='font-size:10px' ># As per company policy</span><br><br>
	<span style='font-size:10px' ># CTC annexure is confidential information. Please do not share it with anyone else it will be viewed seriously.</span><br>
	
	<br/>
		<table cellpadding='0' cellspacing="0" border='0' align='center' style='font-weight:bold; width:100%;'>
		<tr >
			<td style="height:30px;">For Competent Synergies Private Limited.</td>
			<td style="height:30px;">I hereby accept the above offer<br/></td>
		</tr>
		<tr >
			<td style="height:80px;">
			<!--<img height='80px' src="<?php APPPATH ?>main_img/stamp_cspl.jpg" alt="signature" />-->
			<img height='50px' src="<?php APPPATH ?>main_img/cha_hr_arun_kumar_mishra_signature.png" alt="signature" />
			<br/></td>
			<td style="height:80px;">Signature:......................................................<br/><br/></td>
		</tr>
		<tr>
			<td style="height:30px;">
				Arun Kumar Mishra<br> Assistant General Manager-Human Resources
			</td>
			<td style="height:30px;">Name:.............................................................</td>
		</tr>
		</table>

	</div>
		
</div>					
					
					