<?php

	$gross_pay = $can_dtl_row['gross_pay'];
	$location = $can_dtl_row['location'];
	$org_role = $can_dtl_row['org_role'];
	if($location=="") $location = $can_dtl_row['pool_location'];
	
	/*$basic = get_basic($gross_pay, $location);
	$hra =  get_hra($basic, $location);
	
	$conveyance = get_conveyance($gross_pay, $location);
	$other_allowance = get_allowance($gross_pay, $basic, $hra,$conveyance, $location);
	
	$pf = get_pf($basic, $location);
	$ptax = get_ptax($gross_pay, $location);
	
	$esi_employer = get_esi_employer($gross_pay, $location);
	$esi_employee = get_esi_employee($gross_pay, $location);
	
	$ctc = $gross_pay + $esi_employer + $pf;
	$tk_home = round($gross_pay - ($pf + $esi_employee + $ptax ));
	*/
?>
			
<div style="margin:5px;">	
	
	
	<div id="body1" style='width:100%;'>
		<br/><br/><br/><br/>
		<P style='text-align:left;'>Date: <?php echo date("d/m/Y") ?></P>
		
		<strong>Name:</strong> <?php echo $can_dtl_row['fname'].' '.$can_dtl_row['lname'] ?>
		<br>
		Address: <?php echo $can_dtl_row['address'];?>	
		<P style='font-size:15px; text-align:center; font-weight:bold;'>Subject: Stipend Letter</P>
		
		<span>Dear <?php echo $can_dtl_row['fname'].' '.$can_dtl_row['lname'] ?>,</span>
		<br><br>
		
		<span style="font-size:15px;">This is in reference to your application and the subsequent interview with us for the position of <b>“<?php echo $can_dtl_row['position_name'];?>”</b> in our organization. We are pleased to inform you that you have been selected against this vacancy for our organization. Please refer to your offered salary as mentioned below:</span>
		<br><br>
		<span style='font-size:15px; font-weight:bold;'>Offered Stipend:  CTC <?php echo $gross_pay; ?>./- p.m.</span>
		<br><br>
		<span style="font-size:15px;">We look forward to have you onboard with us on <?php echo $can_dtl_row['doj'] ?></span>
		<br>
		<p style="font-size:15px">
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
		<span>10. Medical Fitness Certificate</span>
		</p>
		
			
		<P style='text-align:justify;'>You are requested to confirm your acceptance by signing a copy of this offer letter and contact the HRD representative on the mutually agreed date of joining.  You shall be issued a formal letter of appointment with detailed compensation structure upon joining the organization.</p>
		
		
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
						
		
		
</div>
	

					
</div>					
					
					