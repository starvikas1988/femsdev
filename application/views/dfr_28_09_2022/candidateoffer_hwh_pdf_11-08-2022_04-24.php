<?php

	$gross_pay = $can_dtl_row['gross_pay'];
	$location = $can_dtl_row['location'];
	$org_role = $can_dtl_row['org_role'];
	$pay_type= $can_dtl_row['pay_type'];
	$gender = $can_dtl_row['gender'];
	$incentive_amt = $can_dtl_row['incentive_amt'];
	$incentive_period = $can_dtl_row['incentive_period'];
	$joining_bonus = $can_dtl_row['joining_bonus'];
	$variable_pay=$can_dtl_row['variable_pay'];
	if($location=="") $location = $can_dtl_row['pool_location'];
	
	$basic = get_basic($gross_pay, $location, $org_role);
	$hra =  get_hra($basic, $location, $org_role);
	
	$conveyance = get_conveyance($gross_pay, $location);
	$other_allowance = get_allowance($gross_pay, $basic, $hra,$conveyance, $location);
	
	$ptax = get_ptax($gross_pay, $location, $gender);
	
	$pf = get_pf($basic, $location);	
	
	$gr_amt_esi =  $gross_pay - $conveyance;
	
	$esi_employer = get_esi_employer($gr_amt_esi, $location, $gross_pay);
	$esi_employee = get_esi_employee($gr_amt_esi, $location, $gross_pay);
	
	if($pay_type=="8"){
		$pf=0;
		$esi_employer=0;
		$esi_employee=0;
	}
	
	$ctc = $gross_pay + $esi_employer + $pf;
	$tk_home = round($gross_pay - ($pf + $esi_employee + $ptax ));
	
	if($org_role==13) $notice_period='30';
	else $notice_period='90';
	
	
?>
			
<div style="margin:5px;">	
	
	
	<div id="body1" style='width:100%;'>
		<br/><br/><br/><br/>
		<P style='text-align:right;'>Date: <?php echo date("d/m/Y") ?></P>
		
		<strong>Name:</strong> <?php echo $can_dtl_row['fname'].' '.$can_dtl_row['lname'] ?>
		<br>
		Address: <?php echo $can_dtl_row['address'];?>	
		<P style='font-size:15px; text-align:center; font-weight:bold;'>Re: Letter of Offer</P>
		
		<span>Dear <?php echo $can_dtl_row['fname'].' '.$can_dtl_row['lname'] ?>,</span>
		<br>
		<br>
		<span>We are pleased to offer you the position of “<?php echo $can_dtl_row['position_name'];?>” for Window Technologies and its group of companies.</span>
		<P style='text-align:justify;'>This offer is contingent upon proof of employment eligibility, background and reference check, and confirmation that you are not bound by any contractual agreements that restrict your ability to perform your duties for Window Technologies Pvt. Ltd., and any of its subsidiary companies. </p>
		<span>The organization reserves the right to make your employment contingent on additional requirements.</span>
		<br>
		<span>We are offering this position to you based on the terms listed below</span>
		<br><br>
		<span style='font-size:15px; font-weight:bold; '>TERM START: </span>
		<br>
		<span>We look forward to have you onboard with us by <?php echo $can_dtl_row['doj'] ?></span>
		<br><br>
		<span style='font-size:15px; font-weight:bold; '>COMPENSATION PACKAGE: </span>
		<br>
		
		<?php if($pay_type=="9"){ ?>
			<span> Your offered  fixed CTC will be Rs. <?php echo $ctc; ?> per month and Rs. <?php echo ($ctc*12); ?> per annum and you will be eligible for variable performance incentive in addition to your fixed CTC . The CTC detail is provided in the attached Annexure.</span>
		<?php }else{ ?>
			<span>Your offered CTC will be Rs. <?php echo $ctc; ?> per month and Rs. <?php echo ($ctc*12); ?> per annum. The CTC detail is provided in the attached Annexure.</span>
		<?php } ?>
		<br>
		<br>
		<?php if($incentive_amt > 0 || $joining_bonus > 0){ ?>
			<span style='font-size:15px; font-weight:bold; '>ADDITIONAL Remuneration: </span>
			<span> <?php if($incentive_amt > 0) echo "$incentive_period Incentive Amount: Rs. $incentive_amt "; if($joining_bonus > 0) echo " Joining Bonus: Rs. $joining_bonus"; ?></span>
		<?php } ?>
		<?php if($variable_pay > 0 ){ ?>
                       
			<span>Variable Pay:</span>
			<span> &nbsp;Rs.<?php echo $variable_pay; ?></span>
		<?php } ?>
		<br><br>
		<span>Benefits: You would be entitled to such benefits as may be provided from time-to time as per Company policy.</span>
		<br><br>
		<span style='font-size:15px; font-weight:bold; '>ADDITIONAL TERMS: </span>
		<br><br>
		<span style='font-size:15px; font-weight:bold; '>PLACEMENT: </span>
		<br>
		<span>You will be positioned in <?php echo $can_dtl_row['location_name'];?>. office, India.</span>
		
		<P style='text-align:justify;'> <span style='font-size:15px; font-weight:bold; '>PROBATION: </span> <br/> You will be on probation for a period of six (6) calendar months from the date of joining. The Management reserves the right to terminate this appointment without assigning any reason, whatsoever, during your probation period. The Management, at its discretion, may extend your probationary period.</p>
		
		<span style='font-size:15px; text-align:center; font-weight:bold; '>CONFIRMATION: </span>
		<br>
		<span>On satisfactory completion of your probationary period, your service will be confirmed. Management’s decision in this regard shall be final.</span>
		<br><br>
			
			
		<div style="page-break-after: always"><span style="display: none;">&nbsp;</span></div>
				
		<br/><br/><br/><br/>
		<P style='text-align:justify;'> <span style='font-size:15px; font-weight:bold; '>SEPARATION AND NOTICE PERIOD: </span><br/>In case of separation with the company, if you are deployed in any other country for carrying out official work you should return to your origin station at India for handover of charges and obtain written clearance from all relevant departments after submission of all work authorization documents, work related documents, permits, company assets etc. to the concerned departments at India office. If you want to resign voluntarily you have to serve a notice period of <?php echo $notice_period; ?> days as mandatory unless you are released by your Reporting Manager and HR Manager after deciding a mutually agreed early release date. The notice period is not negotiable on any terms to any day less than the specified number of days as mentioned above.</p>
				
		<P style='text-align:justify;'> <span style='font-size:15px; font-weight:bold; '>ACCEPTANCE INSTRUCTIONS: </span> <br/>You are requested to confirm your acceptance by signing a copy of this offer letter and forward us the same in scanned copy. Should you accept this offer, we will formalize the terms of your employment in a separate employment agreement, which you will be required to sign and which may contain additional terms and conditions to those listed above. </p>
		
		<span>Therefore, the terms listed above do not constitute a binding agreement and ONLY serve as evidence of negotiations concerning your employment. If you have any questions regarding this employment offer, please let us know.</span>
		<br><br>
		<span style='font-size:15px; font-weight:bold; '>JOINING DOCUMENTS: </span><br>
		<span>You are required to carry the following documents at the time of your joining:</span><br>
		<span>1. Copy of all your educational certificates, </span><br>
		<span>2. Accepted resignation letter of the last organization and last drawn salary slip (in original) </span><br>
		<span>3. Salary bank statement of last six months </span><br>
		<span>4. Appointment / experience letter of the last organization, </span><br>
		<span>5. Passport size photographs-4, </span><br>
		<span>6. Passport Copy </span><br>
		<span>7. PAN Card Copy </span><br>
		<span>8. AADHAR Card Copy</span><br>
		<span>9. Proof of Residential address if address is different than Aadhar Card,</span><br>
		<span>10. Medical Fitness Certificate</span><br>
		<span>11. Your joining will be confirmed post providing the Vaccination Documents</span>
		<br><br>
		<span>We are excitingly looking forward to having you join our team,</span>
		<br><br>
		<span>Congratulations and best wishes,</span>
		<br/>
		
		<table cellpadding='0' cellspacing="0" border='0' align='center' style='font-weight:bold; width:100%;'>
		<tr >
			<td style="height:30px;">For WINDOW TECHNOLOGIES PVT LTD.</td>
			<td style="height:30px;">I hereby accept the above offer<br/></td>
		</tr>
		<tr >
			<td style="height:80px;">
			<img height='80px' src="<?php APPPATH ?>main_img/windows_stamp.jpg" alt="signature" />
			<br/></td>
			<td style="height:80px;">Signature:......................................................<br/><br/></td>
		</tr>
		<tr>
			<td style="height:30px;">
				Oindrila Banerjee<br> Senior Manager-HR
			</td>
			<td style="height:30px;">Name:.............................................................</td>
		</tr>
		</table>
		
		<br>
						
		<div style="page-break-after: always"><span style="display: none;">&nbsp;</span></div>
		
		<br><br><br><br/>
		<P style='text-align:right;font-size:10px'><strong>Name:</strong> <?php echo $can_dtl_row['fname'].' '.$can_dtl_row['lname'] ?></P>
		
		<br><br>
		<P style='text-align:center;font-size:16'><strong>ANNEXURE</P>
		<br/><br/><br>
				
		<table cellpadding='2' cellspacing="0" border='1' align='center' style='font-size:12px; text-align:center; width:50%;'>
			<tr bgcolor="#A9A9A9">
				<th><strong>Salary Components</strong></th>
				<th><strong>Monthly</strong></th>
				<th><strong>Yearly</strong></th>		
			</tr>
			<tr>
		<tr>
		<td>Basic</td>
		<td><?php echo $basic; ?></td>
		<td><?php echo ($basic*12); ?></td>		
	</tr>
	<tr>
		<td>HRA</td>
		<td><?php echo $hra; ?></td>
		<td><?php echo ($hra*12); ?></td>		
	</tr>
	<tr>
		<td>Conveyance</td>
		<td><?php echo $conveyance; ?></td>
		<td><?php echo ($conveyance*12); ?></td>		
	</tr>
	<tr>
		<td>Other Allowance</td>
		<td><?php echo $other_allowance; ?></td>
		<td><?php echo ($other_allowance*12); ?></td>		
	</tr>
	<tr bgcolor="#D3D3D3">
		<td>TOTAL EARNING</td>
		<td><?php echo $gross_pay; ?></td>
		<td><?php echo ($gross_pay*12); ?></td>		
	</tr>
	<tr>
		<td>PF (Employer's)</td>
		<td><?php echo $pf; ?></td>
		<td><?php echo ($pf*12); ?></td>
	</tr>
	<tr>
		<td>ESIC (Employer's)</td>
		<td><?php echo $esi_employer; ?></td>
		<td><?php echo ($esi_employer*12); ?></td>		
	</tr>
	<tr bgcolor="#D3D3D3">
		<td>CTC</td>
		<td><?php echo $ctc; ?></td>
		<td><?php echo ($ctc*12); ?></td>		
	</tr>
	<tr>
		<td>P.Tax</td>
		<td><?php echo $ptax; ?></td>
		<td><?php echo ($ptax*12); ?></td>
	</tr>
	<tr>
		<td>ESIC (Employee's)</td>
		<td><?php echo $esi_employee; ?></td>
		<td><?php echo ($esi_employee*12); ?></td>
	</tr>
	<tr>
		<td>PF (Employee's)</td>
		<td><?php echo $pf; ?></td>
		<td><?php echo ($pf*12); ?></td>
	</tr>
	<tr bgcolor="#D3D3D3">
		<td>Take Home</td>
		<td><?php echo $tk_home; ?></td>
		<td><?php echo ($tk_home*12); ?></td>
	</tr>
		</table>	

		<br><br>
		
	<?php if($incentive_amt > 0){ ?>
		<span>Additional incentive- <?php echo "Rs. ".$incentive_amt. " " .$incentive_period; ?></span>
	<?php } ?>	
		
	</div>
					
</div>					
					
					