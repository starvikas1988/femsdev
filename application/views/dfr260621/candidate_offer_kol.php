<?php

	$gross_pay = $can_dtl_row['gross_pay'];
	$location = $can_dtl_row['location'];
	$org_role = $can_dtl_row['org_role'];
	$pay_type= $can_dtl_row['pay_type'];
	
	if($location=="") $location = $can_dtl_row['pool_location'];
	
	$basic = get_basic($gross_pay, $location,$org_role);
	$hra =  get_hra($basic, $location,$org_role);
	
	$conveyance = get_conveyance($gross_pay, $location);
	$other_allowance = get_allowance($gross_pay, $basic, $hra,$conveyance, $location);
	$ptax = get_ptax($gross_pay, $location);
	
	$pf = get_pf($gross_pay, $location);
	$esi_employer = get_esi_employer($gross_pay, $location);
	$esi_employee = get_esi_employee($gross_pay, $location);
	
	if($pay_type=="8"){
		$pf=0;
		$esi_employer=0;
		$esi_employee=0;
	}
	
	$ctc = $gross_pay + $esi_employer + $pf;
	$tk_home = round($gross_pay - ($pf + $esi_employee + $pf ));
	
?>

<div class="wrap">
	<section class="app-content">
		
		<div class="row">
			<div class="col-md-12">
				<div class="widget">
					<header class="widget-header">
						
						<div style="float:right; margin-top:-7px">
							<form id='f1' method="post" action="<?php echo base_url();?>dfr/candidate_offer_pdf/<?php echo $c_id ;?>" target="_blank">
								<button type="submit" class="form-controll btn btn-info" >Dowload PDF</button>
							</form>
						</div>
					</header>

					
<div id="body1" style='width:52%; padding-left:5px;'>
<img src='<?php echo base_url() ?>assets/images/logoxt.jpg' height='100' width='150' border='0'></br>
Date: <?php echo date("d/m/Y") ?>
</br>
</br>
<strong>Name:</strong> <?php echo $can_dtl_row['fname'].' '.$can_dtl_row['lname'] ?>
</br>
Address:<?php echo $can_dtl_row['address'];?>
</br>
</br>
<span style='font-size:16px; text-align:center; font-weight:bold; padding-left:35%;'>Re: Letter of Offer</span></br>
</br>
<span>Dear <?php echo $can_dtl_row['fname'].' '.$can_dtl_row['lname'] ?>,</span>
</br>
</br>
<span>We are pleased to offer you the position of “<?php echo $can_dtl_row['position_name'];?>” for Xplore-Tech and its group of companies.</span>
</br></br>
<span>This offer is contingent upon proof of employment eligibility, background and reference check, and confirmation that you are not bound by any contractual agreements that restrict your ability to perform your duties for Xplore-Tech Services Pvt. Ltd., and any of its subsidiary companies. </span>
</br></br>
<span>The organization reserves the right to make your employment contingent on additional requirements.</span>
</br></br>
<span>We are offering this position to you based on the terms listed below</span>
</br></br>
<span style='font-size:16px; text-align:center; font-weight:bold; '>TERM START: </span>
</br></br>
<span>We look forward to have you onboard with us by <?php echo $can_dtl_row['doj'] ?></span>
</br></br>
<span style='font-size:16px; text-align:center; font-weight:bold; '>COMPENSATION PACKAGE: </span>
</br></br>
<span>CTC: Your offered CTC package will be Rs. <?php echo ($ctc*12); ?>.00 Fixed per annum. The CTC detail is provided in the attached Annexure.</span>
</br></br>
<span>Benefits: You would be entitled to such benefits as may be provided from time-to time as per Company policy.</span>
</br></br>
<span style='font-size:16px; text-align:center; font-weight:bold; '>ADDITIONAL TERMS: </span>
</br></br>
<span style='font-size:16px; text-align:center; font-weight:bold; '>PLACEMENT: </span>
</br></br>
<span>You will be positioned in <?php echo $can_dtl_row['location'];?>. office, India.</span>
</br></br>
<span style='font-size:16px; text-align:center; font-weight:bold; '>PROBATION: </span>
</br></br>
<span>You will be on probation for a period of six (6) calendar months from the date of joining. The Management reserves the right to terminate this appointment without assigning any reason, whatsoever, during your probation period. The Management, at its discretion, may extend your probationary period.</span>
</br></br>
<span style='font-size:16px; text-align:center; font-weight:bold; '>CONFIRMATION: </span>
</br></br>
<span>On satisfactory completion of your probationary period, your service will be confirmed. Management’s decision in this regard shall be final.</span>
</br></br>
<span style='font-size:16px; text-align:center; font-weight:bold; '>SEPARATION: </span>
<span>In case of separation with the company, if you are deployed in any other country for carrying out official work you should return to your origin station at India for handover of charges and obtain written clearance from all relevant departments after submission of all work authorization documents, work related documents, permits, company assets etc. to the concerned departments at India office.</span>
</br></br>
<span style='font-size:16px; text-align:center; font-weight:bold; '>ACCEPTANCE INSTRUCTIONS: </span>
<span>You are requested to confirm your acceptance by signing a copy of this offer letter and forward us the same in scanned copy. Should you accept this offer, we will formalize the terms of your employment in a separate employment agreement, which you will be required to sign and which may contain additional terms and conditions to those listed above. </span>
</br></br>
<span>Therefore, the terms listed above do not constitute a binding agreement and ONLY serve as evidence of negotiations concerning your employment. If you have any questions regarding this employment offer, please let us know.</span>
</br></br>
<span style='font-size:16px; text-align:center; font-weight:bold; '>JOINING DOCUMENTS: </span><br>
<span>You are required to carry the following documents at the time of your joining:</span></br>
<span>1. Copy of all your educational certificates, </span></br>
<span>2. Accepted resignation letter of the last organization and last drawn salary slip (in original) </span></br>
<span>3. Salary bank statement of last six months </span></br>
<span>4. Appointment / experience letter of the last organization, </span></br>
<span>5. Passport size photographs-4, </span></br>
<span>6. Passport Copy </span></br>
<span>7. PAN Card Copy </span></br>
<span>8. AADHAR Card Copy</span></br>
<span>9. Proof of Residential address if address is different than Aadhar Card,</span></br>
<span>10. Medical Fitness Certificate</span>
</br></br>
<span>We are excitingly looking forward to having you join our team,</span>
</br></br>
<span>Congratulations and best wishes,</span>
</br></br>
<span style='font-size:14px; text-align:center; font-weight:bold; '>For XPLORE-TECH SERVICES PVT. LTD. </span>
</br></br>
.....................................<br>
<span style='font-size:14px; text-align:center; font-weight:bold; '>Talent Acquisition Team</span>
</br></br>
<span style='font-size:14px; text-align:center; font-weight:bold; '>I hereby accept the above offer and confirm to join on <?php echo $can_dtl_row['doj'] ?></span>
</br></br>
.....................................<br>
<span style='font-size:14px; text-align:center; font-weight:bold; '>Sign:</span>

</br></br>
<span style='font-size:14px; text-align:left; font-weight:bold; '>Name:---------------</span>
<span style='font-size:14px; text-align:right; font-weight:bold; padding-left:50% '>Date:---------------</span>
</br></br>

<center>
<table cellpadding='2' cellspacing="0" border='1' style='font-size:12px; text-align:center; width:50%'>
	<tr bgcolor="#A9A9A9">
		<th><strong>Salary Components</strong></th>
		<th><strong>Monthly</strong></th>
		<th><strong>Yearly</strong></th>		
	</tr>
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
</center>


<center>
	<p><span style='font-size:18px'>XPLORE-TECH SERVICES PRIVATE LIMITED</span></br>
		<span style='font-size:12px'>CIN: U72900WB2004PTC097921</span></br>
		<span style='font-size:12px'><i>(A Fusion BPO Services Company)</i></span></br>
		<span style='font-size:12px'>Plot Y9, Block-EP, Sector-V, Salt Lake City, Kolkata-700091</span></br>
		<span style='font-size:12px'>www. xplore-tech.com | www.fusionbposervices.com</span>
	</p>

</center>

</div>

					
					
				</div>
			</div>
		</div>
		
		
	</section>
</div>	