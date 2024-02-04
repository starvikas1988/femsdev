<?php

$per_day_array = array(2, 3, 10, 11);

$approved_on = date_format(date_create($can_dtl_row['approved_on']), 'Y-m-d');
if ($can_dtl_row['approved_on'] == "") $approved_on = '';
$gross_pay = $can_dtl_row['gross_pay'];
$location = $can_dtl_row['location'];
$org_role = $can_dtl_row['org_role'];
$pay_type = $can_dtl_row['pay_type'];
$payroll_type_name = $can_dtl_row['payroll_type_name'];
$incentive_amt = $can_dtl_row['incentive_amt'];
$incentive_period = $can_dtl_row['incentive_period'];
$joining_bonus = $can_dtl_row['joining_bonus'];
$variable_pay = $can_dtl_row['variable_pay'];
$training_fees = $can_dtl_row['training_fees'];
if ($training_fees == "") $training_fees = 200;
$emp_type = $can_dtl_row['emp_type'];
$rank = $can_dtl_row['rank'];

if ($location == "") $location = $can_dtl_row['pool_location'];

$basic = get_basic($gross_pay, "CHA", $org_role);
$ptax = get_ptax($gross_pay, $location);
//no conveyance allowance
$esi_employer = get_esi_employer($gross_pay, "CHA", $gross_pay);
$esi_employee = get_esi_employee($gross_pay, "CHA", $gross_pay);

$brand = $can_dtl_row['company'];
if($brand=="") $brand = $can_dtl_row['brand'];

$singDtls = get_signature_details($location, $org_role, $rank, $brand, $can_dtl_row['doj']);

$for_comp = $singDtls['company'];
$signature_text = $singDtls['signature_text'];
$signature_img = $singDtls['signature_img'];
	

?>

<div style="margin:5px;">


	<div id="body1" style='width:100%;'>
		<br /><br /><br />
		<P style='text-align:left;'>LOI Issue Date: <?php echo $approved_on;  ?></P>
		<strong>Name:</strong> <?php echo $can_dtl_row['fname'] . ' ' . $can_dtl_row['lname'] ?>
		<br>
		Address: <?php echo $can_dtl_row['address']; ?>
		<P style='font-size:15px; text-align:center; font-weight:bold;'>Subject: Letter of Offer (<?php echo $payroll_type_name; ?>)</P>
		<span>Dear <?php echo $can_dtl_row['fname'] . ' ' . $can_dtl_row['lname'] ?>,</span>
		<br><br>
		<span>This is with reference to your application/CV/interest to join CSPL and subsequent discussions/interview you had with us. We are pleased to offer you this Letter of Intent to join training with <b>Competent Synergies Private Limited,</b> subject to the following terms and conditions:</span><br><br>

		<span>You have been shortlisted for <u><b><?php echo $can_dtl_row['position_name']; ?></b></u> as<b> On Job Trainee.</b></span><br>
		<span>You shall report at the below mentioned address after lockdown period (which will be intimated separately).</span><br>
		<span>Competent House Plot No. C-157, Industrial Area, Phase-7, Mohali – 160055, Punjab.</span><br>
		
		<?php 
			$slno=1;
			
			if($emp_type==6){
		?>	
			<P style='text-align:justify; margin-top: 5px; margin-bottom: 0px;'>
			<span><?php echo $slno++ ?>. This offer/apprenticeship will be valid for <?php echo $can_dtl_row['contract_dur_days'] ?> days, or it may get extended. </span>
			</p>
		<?php } ?>
		
		
		<P style='text-align:justify; margin-top: 5px; margin-bottom: 0px;'>
			<span><?php echo $slno++ ?>. The commencement of your Training/Joining will be from <b> <u><?php echo $can_dtl_row['doj']; ?></u></b> and can be subject to <u>Work from Home basis or Work from Office basis.</u></span>
		</p>
		<P style='text-align:justify; margin-top: 5px; margin-bottom: 0px;'>
			<span><?php echo $slno++ ?>. Training Period would be of <b>15 to 20 days</b>.</span>
		</p>
		<P style='text-align:justify; margin-top: 5px; margin-bottom: 0px;'>
			<span><?php echo $slno++ ?>. Training batch timings will be from <b>9 am to 6 pm</b> with breaks.</span>
		</p>
		<P style='text-align:justify; margin-top: 5px; margin-bottom: 0px;'>
			<span><?php echo $slno++ ?>. Training timings can be changed based on the business requirement by your respective trainer.</span>
		</p>
		<P style='text-align:justify; margin-top: 5px; margin-bottom: 0px;'>
			<span><?php echo $slno++ ?>. Please note that your joining CSPL is subject to meeting all the following conditions mentioned here under:</span>
		</p>
		<p style='margin-left: 30px; margin-top: 4px;'>
			<span> i. You will have to clear the client round of interview before the start of your training.</span><br>
			<span>ii. You will have to complete the training successfully.</span><br>
			<span>iii. There should not be any complaint of mis-conduct and/or behavior against you, verbal or written by Trainer and/or HR.</span><br>
			<span>iv. You will have to be certified as “Passed” by your trainer and/or Client.</span><br>
			<span>v. Your joining CSPL is subject to positive Reference Check and Police Verification.</span>
		</p>
		<P style='text-align:justify; margin-top: 4px; margin-bottom: 5px;'>
			<span><?php echo $slno++ ?>. Please note that the training or subsequent employment with the CSPL is subject to either <b>Work from Home</b> or <b>Work from Office</b> as per the requirements of the business, process or client.</span>
		</p>
		<span><?php echo $slno++ ?>. Please note that training fees is payable if the training period is more than seven working days.</span><br>
		<P style='text-align:justify; margin-top: 5px; margin-bottom: 0px;'>
			<span><?php echo $slno++ ?>. Please note that in the event of your not clearing training, you will not be paid training fee and any other costs</span>
		</p>
		<P style='text-align:justify; margin-top: 5px; margin-bottom: 0px;'>
			<span><?php echo $slno++ ?>. Please note that the continuance of your <b>“On Job Training” / Service </b> with CSPL is also subject to availability of work with CSPL and/or our client companies. In case of non-renewal of contract or non-availability of work with the client companies or CSPL, your “On Job Training” / services would be liable to be discontinued with immediate effect without giving any further notice or compensation in this regard.</span>
		</p>
		<P style='text-align:justify; margin-top: 5px; margin-bottom: 0px;'>
			<span><?php echo $slno++ ?>. <b>Force Majeure:</b> The obligations of CSPL with respect to this offer shall be suspended when the company is subject to Force Majeure, which can be termed as civil disturbance, riots, strikes, storm, tempest, acts of God, emergency etc., </span>
		</p>
		<div style="page-break-after: always"><span style="display: none;">&nbsp;</span></div>
		<br /><br /><br /><br />

		<P style='text-align:justify; margin-top: 5px; margin-bottom: 0px;'>
			<span><?php echo $slno++ ?>. You will have to provide your bank account details to the company along with a "cancelled cheque"/"photocopy of passbook" or you are required to get your account opened during the training before certification. </span>
		</p>
		<P style='text-align:justify; margin-top: 5px; margin-bottom: 0px;'>
			<span><?php echo $slno++ ?>. You need to provide scanned copy of following documents at email id - harpreet.singh@mail.competentsynergies.com within first 3 days of your joining in training. You will be allowed to appear for certification post completion of training only after submission of documents as mentioned below: </span>

		</p>
		<p style='margin-left: 30px; margin-top: 4px;'>
			<span> a) Copy of Aadhar Card (Compulsory).</span><br>
			<span> b) Date of Birth Proof Certificate (Scanned copy of passport, birth certificate) (Xerox Copy).</span><br>
			<span> c) Copy of academic certificates (Scanned copy).</span><br>
			<span> d) Relieving letter from previous employer (If experienced).</span><br>
			<span> e) Proof of compensation last drawn (Salary Slip/Salary certificate).</span><br>
			<span> f) Passport size photographs (four).</span><br>
			<span> g) Identity proof: Pan card / Passport / Driving License / Ration card / Voter card.</span>
		</p>
		<P style='text-align:justify; margin-top: 5px; margin-bottom: 0px;'>
			<span><?php echo $slno++ ?>. In case of any dispute/clarification, you may contact HR Department. </span>
		</p>
		<P style='text-align:justify; margin-top: 5px; margin-bottom: 5px;'>
			<span><?php echo $slno++ ?>. It is clearly understood that you will carry out duties/responsibilities diligently, honestly and efficiently. The company reserves the right to terminate your On Job Training/services without notice if it comes to its knowledge that you have indulged in any act of negligence or dishonesty or any act detrimental to the interest of the company. This is without prejudice to the right of the company to claim damages from you. </span>
		</p>

		<span><?php echo $slno++ ?>. Please note that the attached Stipend Annexure forms a part of this Letter of Intent. </span><br>

		<P style='text-align:center;font-size:15px'><strong>Stipend Annexure</P><br>

		<span>You will be paid Total Stipend of <strong>Rs. <?php echo $can_dtl_row['gross_pay']; ?>/- ( <?php echo getIndianCurrency($can_dtl_row['gross_pay']); ?> ) </strong> which is subject to your successful completion of training and client certification.</span><br>
		<?php if ($incentive_amt > 0 || $joining_bonus > 0) { ?>
			<span>Additional Remuneration:</span>
			<span> &nbsp;<?php if ($incentive_amt > 0) echo "$incentive_period Incentive Amount: Rs. $incentive_amt ";
							if ($joining_bonus > 0) echo " &nbsp; Joining Bonus: Rs. $joining_bonus"; ?></span><br>
		<?php } ?>
		<?php if ($variable_pay > 0) { ?>
			<span>Variable Pay:</span>
			<span> &nbsp;Rs.<?php echo $variable_pay; ?></span>
		<?php } ?>
		<br>
		
		<table cellpadding='2' cellspacing="0" border='1' align='center' style='font-size:12px; text-align:center; width:70%;'>

			<tr>
				<td colspan='2'>PAY STRUCTURE - OJT</td>
			</tr>

			<tr bgcolor="#A9A9A9">
				<th><strong>Salary Components</strong></th>
				<th><strong>Amount in Rupees (Monthly)</strong></th>
			</tr>
			<tr>
			<tr>
				<td style="text-align:left;">Gross Stipend</td>
				<td><?php echo $gross_pay; ?></td>
			</tr>
			<tr>
				<td style="text-align:left;">Employee ESI- @ 0.75% of Gross Stipend</td>
				<td><?php echo $esi_employee; ?></td>
			</tr>
			<tr>
				<td style="text-align:left;">Total In Hand </td>
				<td><?php echo ($gross_pay - $esi_employee); ?></td>
			</tr>
			<tr>
				<td style="text-align:left;">Employer ESI- @ 3.25% of Gross Stipend</td>
				<td><?php echo $esi_employer; ?></td>
			</tr>
			<tr>
				<td style="text-align:left;">Cost to Company</td>
				<td><?php echo ($gross_pay + $esi_employer); ?></td>
			</tr>

		</table>

		<br>

		<span><b>Payment of Training Stipend:</b></span>
		<p style='margin-left: 30px; margin-top: 5px;'>
			<span>&#10003; You will be entitled for payment of training Stipend @Rs.<?php echo $training_fees; ?> (<?php echo getIndianCurrency($training_fees); ?> Only)per day starting from day one of product/process training subject to clause No.7 the Letter of Intent. As per salary cycle on the successful certification of your training.</span><br>
		<p>
		<div style="page-break-after: always"><span style="display: none;">&nbsp;</span></div>
		<br /><br /><br /><br />

		<span><b>Performance linked Incentive (PLI) described as under:</b></span>
		<p style='margin-left: 30px; margin-top: 5px;'>
			<span>&#10003; Performance linked Incentive are based on criteria fixed by company from time to time.</span><br>
			<span>&#10003; The conditions and criteria's for PLI will be shared monthly with you in advance.</span><br>
			<span>&#10003; PLI is variable and payable on achievement of Certain Level of Performance which is decided by Company from time to time.</span><br>
			<span>&#10003; Performance Linked Incentive for the previous month would be payable after one month.</span><br>
			<span>&#10003; Performance Linked Incentives are subject to modification/withdrawal any time during the year as per the sole discretion of company.</span>
		<p>

			<span><b>Stipend Calculation & Other Deductions:</b></span>
		<p style='margin-left: 30px; margin-top: 5px;'>
			<span>&#10003;There would be nominal deduction of 0.75% of your gross fixed Stipend towards ESI Contribution as per Government norms.</span><br>
			<span>&#10003; You can avail 4 Weekly Offs and 1 Earned leave every month. (Earned Leave can only be availed 2nd month onwards).</span><br>
			<span>&#10003; Shift will be of 9 Hours, out of which 8 hours have to be productive. </span><br>
			<span>&#10003; You have to mark your attendance daily in BMD/Mobile App with Login ID and Password, which will be shared by your Manager. </span><br>
			<span>&#10003; You shall not disclose your attendance and login password with any one and shall not mark false or proxy attendance.</span><br>
			<span>&#10003; You have to login for 4 Hours daily in Case you are a Part Timer and no exception would be given.</span><br>
			<span> &#10003; Your Stipend will be calculated on basis of your login hours of the Process.</span>
		<p>

		<P style='text-align:justify; margin-top: 5px; margin-bottom: 0px;'>
			<span>16. This letter of Intent supersedes any communication verbal or written in regard to your joining CSPL for training or Job given by CSPL and/or employees of CSPL/Consultants. In case of any concern or grievance during the course of your engagement with us please feel free to contact Landline: contact 0172- 5098966, 86799-53399. </span>
		<p>
			<br />
			<span><b>Looking forward towards a long and mutually beneficial association</b></span>
			<br />
			<span>Congratulations and best wishes,</span>
			<br />
		<table cellpadding='0' cellspacing="0" border='0' align='center' style='font-weight:bold; width:100%;'>
			<tr>
				<td style="height:30px;">For Competent Synergies Private Limited.</td>
				<td style="height:30px;">I hereby accept the above offer<br /></td>
			</tr>
			<tr>
				<td style="height:80px;">
					
						<img height='50px' src="<?php APPPATH ?>main_img/cha_hr_arun_kumar_mishra_signature.png" alt="signature" />
						
					<br />
				</td>
				<td style="height:80px;">Signature:......................................................<br /><br /></td>
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