<!DOCTYPE html>
<html lang="en">
<head>
  <title>::OFFER LETTER::</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
<style>
	table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}


</style>
</head>
<body>
	


	<div style="width:800px;max-width:100%;margin:0 auto;display:block;font-family: 'Roboto', sans-serif;">
		<div style="width:100%;">
			<div style="font-size:12px;letter-spacing:0.5px;color:#000;line-height:18px;margin:0 0 20px 0;">
				 <strong>FORM S1</strong>
			</div>
			<div style="font-size:12px;letter-spacing:0.5px;color:#000;line-height:18px;margin:0 0 20px 0; text-align:center;">
				<img src="./uploads/signatures/fusion-logo.png" style="height:70px;" alt="">
			</div>
			<?php 

			 $location = $can_dtl_row['location'];
			if ($location=="MAN") {
			?>
			<div style="font-size:12px;letter-spacing:0.5px;color:#000;line-height:18px;margin:0 0 20px 0;">
				Unit 601-602, 6th Floor The Orient Square Bldg <br>
				F Ortigas Jr. Road Ortigas Center,<br>
				Pasig City
				
			</div>
		<?php } ?>
		<?php 
			if ($location=="CEB") {
			?>
			<div style="font-size:12px;letter-spacing:0.5px;color:#000;line-height:18px;margin:0 0 20px 0;">
				7/F Robinsons Cybergate Building<br>
				Fuente Osmeña, Cebu City Cebu,<br>
				Philippines, 6000
			</div>
			<?php } ?>
			<div style="font-size:12px;letter-spacing:0.5px;color:#000;line-height:18px;margin:0 0 20px 0;">
				Dear <strong><?php echo $can_dtl_row['fname'].' '.$can_dtl_row['lname'] ?></strong>
			</div>
			<div style="font-size:12px;letter-spacing:0.5px;color:#000;line-height:18px;margin:0 0 20px 0;text-decoration:underline;">
				<strong>JOB OFFER</strong>
			</div>
			<div style="font-size:12px;letter-spacing:0.5px;color:#000;line-height:18px;margin:0 0 10px 0;">
				Fusion BPO Services Phils.Inc. is pleased to offer you a job as <strong><?php echo $can_dtl_row['position_name']; ?></strong>. We are confident that your knowledge, skills and experience will be among ourmost valuable assets.
			</div>
			<div style="font-size:12px;letter-spacing:0.5px;color:#000;line-height:18px;margin:0 0 10px 0;">
				Should you accept this job offer, per company policy, you will be eligible to receive the following beginning your hire date:
			</div>
			<div style="font-size:12px;letter-spacing:0.5px;color:#000;line-height:18px;margin:0 0 10px 0;">
				<ul style="margin:0 0 0 -15px;">
					<li style="margin:0 0 5px 0;">
						<strong>COMPENSATION AND BENEFITS</strong> 
					</li>
				</ul>
			</div>
			<div style="font-size:12px;letter-spacing:0.5px;color:#000;line-height:18px;margin:0 0 10px 0;">
			<table style="width:100%;text-align:center;font-family: 'Roboto', sans-serif;font-size:12px;">	  
				  <tr>
					<td>Monthly Basic Salary</td>
					<td>Php</td>
					<td><?php echo $can_dtl_row['basic_salary']; ?></td>
					<td>Taxable l Paid in bi-monthly installments by direct ATM deposit</td>
				  </tr>
				  <tr>
					<td>Night Differential</td>
					<td>Php</td>
					<td><?php echo $can_dtl_row['night_differential']; ?></td>
					<td>Taxable l Pro-rated Number of Hours Worked between 10PM to 6AM.</td>
				  </tr>
				  <tr>
					<td>Deminimis</td>
					<td>Php</td>
					<td><?php echo $can_dtl_row['deminimis']; ?></td>
					<td></td>
				  </tr>
				  <tr>
					<td>Standard Incentive</td>
					<td>Php</td>
					<td><?php echo $can_dtl_row['standard_incentive']; ?></td>
					<td></td>
				  </tr>
				  <tr>
					<td>Account Premium</td>
					<td>Php</td>
					<td><?php echo $can_dtl_row['account_premium']; ?></td>
					<td>Subject to 2% tax. Account Terminus</td>
				  </tr>
				  <tr>
					<td><strong>TOTAL</strong></td>
					<td><strong>Php</strong></td>
					<td><?php echo $can_dtl_row['total_amount']; ?></td>
					<td></td>
				  </tr>
				</table>
			</div>
			<div style="font-size:12px;letter-spacing:0.5px;color:#000;line-height:18px;margin:0 0 10px 0;">
				<ul style="margin:0 0 0 -15px;">
					<li style="margin:0 0 5px 0;">
						<strong>BENEFITS:</strong> Standards, Fusion BPO Services Phils.Inc., provided benefits for salaried-exempt employees include the following:
					</li>
					<li style="margin:0 0 5px 0; text-align:justify;">
						Health, dental, life and disability insurance(on the 3rd month of employment.To follow your respective 1 FREE dependent upon regularization)
					</li>
					<li style="margin:0 0 5px 0;">
						Sick Leave, Vacation and personal daysoff(PTO) – upon regularization.
					</li>
				</ul>
			</div>
			<div style="font-size:12px;letter-spacing:0.5px;color:#000;line-height:18px;margin:0 0 30px 0;">
				We at Fusion BPO Services Phils. Inc. hope that you will accept this job offer and look forward to welcoming you aboard.
			</div>
			<div style="font-size:12px;letter-spacing:0.5px;color:#000;line-height:18px;margin:0 0 30px 0;">
				Sincerely,
			</div>
			<div style="font-size:12px;letter-spacing:0.5px;color:#000;line-height:18px;">
				<img src="./uploads/signatures/signaturesandra.png" alt="">
			</div>
			<div style="font-size:12px;letter-spacing:0.5px;color:#000;line-height:18px;margin:0 0 30px 0;">
				Sandra Fudotan<br>
				<strong>Human Resources Manager</strong>
			</div>
			<div style="font-size:12px;letter-spacing:0.5px;color:#000;line-height:18px;">
				<strong>Accept Job Offer</strong>
			</div>
			<div style="font-size:12px;letter-spacing:0.5px;color:#000;line-height:18px;margin:0 0 30px 0;">
				By signing and dating this letter below, I, <span style="width:200px;height:1px;display:inline-block;"><strong><?php echo $can_dtl_row['fname'].' '.$can_dtl_row['lname'] ?></strong></span> accept this offer letter by Fusion BPO Services Phils. Inc.
			</div>
			<div style="font-size:12px;letter-spacing:0.5px;color:#000;line-height:18px;margin:0 0 30px 0;">
				<div style="display:inline-block;font-weight:bold;float:left;width:50%;text-align:left;">
					<span style="background:#ffff00;color:#000;display:inline-block;">Signature
					</span>
				</div>
				<div style="display:inline-block;float:right;width:50%;text-align:right;">
					Date:<span style="width:100px;height:1px;background:#000;display:inline-block;"></span>
				</div>
			</div>
		</div>
	</div>



<div style="page-break-after: always"><span style="display: none;">&nbsp;</span>&nbsp;</div>
<br>

<?php
 $account_premium=$can_dtl_row['account_premium'];
if ($account_premium >0) {
		
	?>
	<div style="width:800px;max-width:100%;margin:0 auto;display:block;font-family: 'Roboto', sans-serif;">
		<div style="width:100%;">
			<div style="font-size:12px;letter-spacing:0.5px;color:#000;line-height:18px;margin:0 0 5px 0; text-align:center;">
				<img src="./uploads/signatures/fusion-logo.png" style="height:70px;" alt="">
			</div>
			<?php 
			
			$location = $can_dtl_row['location'];
			if ($location=="MAN") {
			?>
			<div style="font-size:12px;letter-spacing:0.5px;color:#000;line-height:18px;margin:0 0 20px 0;text-align:center;">
				Unit 601-602, 6th Floor The Orient Square Bldg<br>
				F Ortigas Jr. Road Ortigas Center, Pasig City<br>
				Phone: 0275068932, Mobile: 09175960354
			</div>
			<?php } ?>
			<?php 
			if ($location=="CEB") {
			?>
			<div style="font-size:12px;letter-spacing:0.5px;color:#000;line-height:18px;margin:0 0 20px 0;text-align:center;">
				US: 405 E, 12450 S, Suite M, Draper, 84020, Utah<br>
				PH: 7F Cybergate Bldg. | Fuente Osmeña | Cebu City | Cebu | PH | 6000<br>
				Phone: 310-734-8225 | Fax: 206-350-0106
			</div>
			<?php } ?>
			<div style="font-size:12px;letter-spacing:0.5px;color:#000;line-height:18px;margin:0 0 20px 0;">
				<strong>DATE</strong>
			</div>

			<div style="font-size:12px;letter-spacing:0.5px;color:#000;line-height:18px;margin:0 0 20px 0;">
				<strong>NAME</strong><br>	
				<?php echo ($location=='CEB')?'Cebu city':'Pasig City';?>
			</div>
			<div style="font-size:12px;letter-spacing:0.5px;color:#000;line-height:18px;margin:0 0 20px 0;">
				<strong><?php echo $can_dtl_row['fname'].' '.$can_dtl_row['lname'] ?></strong>				
			</div>
			<div style="font-size:12px;letter-spacing:0.5px;color:#000;line-height:18px;margin:0 0 10px 0; text-align:justify;">
				We are pleased to inform you that you will be assigned to <span style="font-weight:bold;text-decoration:underline;"><?php echo $can_dtl_row['client_name']; ?></span> account.
			</div>
			<div style="font-size:12px;letter-spacing:0.5px;color:#000;line-height:18px;margin:0 0 10px 0;">
				As a <span style="font-weight:bold;text-decoration:underline;"><?php echo $can_dtl_row['position_name']; ?></span> in the account, you are entitled to Account Premium of Php <span style="font-weight:bold;text-decoration:underline;"><?php echo $can_dtl_row['account_premium']; ?></span> (effectivity is on day 1 PST) per month until your separation from the account
			</div>
			<div style="font-size:12px;letter-spacing:0.5px;color:#000;line-height:18px;margin:0 0 10px 0;">
				Please find below the conditions specific to the Account Premium:
			</div>
			<div style="font-size:12px;letter-spacing:0.5px;color:#000;line-height:18px;margin:0 0 10px 0;">
				<ul style="margin:0 0 0 -15px;">
					<li style="margin:0 0 5px 0; align-content:justify;">
						The Account Premium is not a benefit and is account/program dependent, hence discontinued if the employee is transferred to a different account.
					</li>
					<li style="margin:0 0 5px 0; align-content:justify;">
						The Account Premium shall not form part of the regular base pay and is pro-rated and is subject to number of days present in a calendar month.
					</li>
					<li style="margin:0 0 5px 0; align-content:justify;">
						It shall not establish company practice or additional right to incentive such that FUSION BPO Services Phils. Inc. reserves the right to terminate, end, reduce, alter, decrease or discontinue the account incentive at any time,for any reason, with or without notice.
					</li>
				</ul>
			</div>
			
			<div style="font-size:12px;letter-spacing:0.5px;color:#000;line-height:18px;margin:30px 0;vertical-align:middle;">
				<div style="width:29%;display:inline-block;margin:0 25px 0 0;float:left;">
					<span style="width:100%;height:30px;display:block;"></span>
					<div style="margin:20px 0 0 0;">
						<strong>Immediate Supervisor</strong>
					</div>
				</div>
				<div style="width:29%;display:inline-block;margin:0 25px 0 0;float:left; text-align:center;" id="signatureproghead" name="signatureproghead">
					<img src="./uploads/signatures/<?php echo $progheadsignature;?>" style="margin:0 0 0 50px;display:block;" alt="">
					<div style="text-align:center;">
						<strong>Program Head</strong>
					</div>
				</div>
				<div style="width:29%;float:right;display:inline-block;margin:0 25px 0 0;text-align:center;" >
					<img src="./uploads/signatures/signaturesandra.png" alt="">
					<div style="font-size:12px;letter-spacing:0.5px;color:#000;">
						<strong>Human Resource Division</strong>
					</div>
				</div>
			</div>
			
			<div style="font-size:12px;letter-spacing:0.5px;color:#000;line-height:18px;margin:0 0 30px 0;">
				a. Acknowledgement:
			</div>
			
			
			<div style="font-size:12px;letter-spacing:0.5px;color:#000;line-height:18px;margin:0 0 30px 0;">
				<div style="display:inline-block;font-weight:bold;float:left;width:50%;text-align:left;">
					<span style="background:#ffff00;color:#000;display:inline-block;">Signature over Printed Name
					</span>
				</div>
				<div style="display:inline-block;float:right;width:50%;text-align:right;">
					Date Signed<span style="width:100px;height:1px;background:#000;display:inline-block;"></span>
				</div>
			</div>
			
			
			<div style="font-size:12px;letter-spacing:0.5px;color:#000;line-height:18px;display:block;">
				Cc: Payroll/201
			</div>
		</div>
	</div>
	<div style="page-break-after: always"><span style="display: none;">&nbsp;</span>&nbsp;</div>
<?php } ?>
	<div style="width:800px;max-width:100%;margin:0 auto;display:block;font-family: 'Roboto', sans-serif;">
		<div style="width:100%;/*margin:200px 0 0 0;*/">
			<div style="font-size:12px;letter-spacing:0.5px;color:#000;line-height:18px;margin:0 0 5px 0; text-align:center;">
				<img src="./uploads/signatures/fusion-logo.png" style="height:70px;" alt="">
			</div>
			<?php 
			$location = $can_dtl_row['location'];
			if ($location=="MAN") {
			?>
			<div style="font-size:12px;letter-spacing:0.5px;color:#000;line-height:18px;margin:0 0 20px 0;text-align:center;">
				Unit 601-602, 6th Floor The Orient Square Bldg<br>
				F Ortigas Jr. Road Ortigas Center, Pasig City<br>
				Phone: 0275068932, Mobile: 09175960354
			</div>
			<?php } ?>
			<?php 
			if ($location=="CEB") {
			?>
			<div style="font-size:12px;letter-spacing:0.5px;color:#000;line-height:18px;margin:0 0 20px 0;text-align:center;">
				US: 405 E, 12450 S, Suite M, Draper, 84020, Utah<br>
				PH: 7F Cybergate Bldg. | Fuente Osmeña | Cebu City | Cebu | PH | 6000<br>
				Phone: 310-734-8225 | Fax: 206-350-0106
			</div>
		<?php } ?>
			

			
			<div style="font-size:11px;letter-spacing:0.5px;color:#000;line-height:18px;margin:0 0 20px 0;">
			
			<table style="width:100%;font-family: 'Roboto', sans-serif;font-size:11px;border-collapse: collapse;">	  
				  <tr>
					<td style="width:200px;"><strong>JOB HOLDER</strong></td>
					<td><?php echo $can_dtl_row['fname'].' '.$can_dtl_row['lname'] ?></td>					
				  </tr>
				  <tr>
					<td><strong>POSITION TITLE</strong></td>
					<td><?php echo $can_dtl_row['position_name']; ?></td>					
				  </tr>
				  <tr>
					<td><strong>JOB LEVEL</strong></td>
					<td><?php echo $can_dtl_row['job_level']; ?></td>					
				  </tr>
				  <tr>
					<td><strong>DIVISION</strong></td>					
					<td><?php echo $can_dtl_row['division']; ?></td>					
				  </tr>
				  <tr>
					<td><strong>DEPARTMENT</strong></td>
					<td><?php echo $can_dtl_row['department_name']; ?></td>					
				  </tr>
				  <tr>
					<td><strong>SECTION</strong></td>					
					<td>N/A</td>					
				  </tr>
				  <tr>
					<td><strong>UNIT</strong></td>
					<td>N/A</td>					
				  </tr>
				  <tr>
					<td><strong>IMMEDIATE SUPERIOR</strong></td>
					<td><?php echo $can_dtl_row['immediate_supervisor']; ?></td>					
				  </tr>
				  <tr>
					<td><strong>COORDINATES WITH</strong></td>
					<td><?php echo $can_dtl_row['coordinate_with']; ?></td>					
				  </tr>
				  <tr>
					<td><strong>OVERSEES</strong></td>					
					<td><?php echo $can_dtl_row['overseas']; ?></td>
				  </tr>
				</table>
			</div>
			<div style="font-size:12px;letter-spacing:0.5px;color:#000;line-height:18px;margin:0 0 20px 0;text-align:center;text-decoration:underline;">
				<strong>JOB SUMMARY</strong>
			</div>
			<div style="font-size:12px;letter-spacing:0.5px;color:#000;line-height:18px;margin:0 0 20px 0;">
				<?php echo $can_dtl_row['job_summary']; ?>
			</div>
			<div style="font-size:12px;letter-spacing:0.5px;color:#000;line-height:18px;margin:0 0 20px 0;text-align:center;text-decoration:underline;">
				<strong>JOB DUTIES & RESPONSIBILITIES</strong>
			</div>
			<div style="font-size:12px;letter-spacing:0.5px;color:#000;line-height:18px;margin:0 0 10px 0;text-align:justify;">
				These tasks are subject to change depending on the nature of service of the division/ department or business direction.
			</div>			
			<div style="font-size:12px;letter-spacing:0.5px;color:#000;line-height:18px;margin:0 0 10px 0;">
				<ul style="margin:0 0 0 -15px;">
					<li style="margin:0 0 5px 0;">
						Handles customer calls to promote account’s products orservices.
					</li>
					<li style="margin:0 0 5px 0;">
						Facilitates sales of all product/ services according to customer’s needs.
					</li>
					<li style="margin:0 0 5px 0;">
						Assists and guides customers with all the required knowledge of the product and services.
					</li>
					<li style="margin:0 0 5px 0;text-align:justify;">
						Communicates and interpret customers’ needs by delivering professional, courteous and quality service before, during, and after customer interaction through multiple channels such as:
						<ul>
							<li style="margin:0 0 5px 0;">
								Phone
							</li>
							<li style="margin:0 0 5px 0;">
								Email
							</li>
						</ul>
					</li>
					<li style="margin:0 0 5px 0; text-align:justify;">
						Ensures the accuracy and confidentiality of all customer-related information such as but not limited to : account information, credit card details, billing information.
					</li>
					
					<li style="margin:0 0 5px 0; text-align:justify;">
						Adheres to account-specific procedures, guidelines and policies concerning customer interaction and communication which may cover but not limited to:
						<ul>
							<li style="margin:0 0 5px 0;">
								initiating phone calls to customers
							</li>
							<li style="margin:0 0 5px 0;">
								necessary callbacks
							</li>
							<li style="margin:0 0 5px 0;">
								promptly returning calls
							</li>
							<li style="margin:0 0 5px 0;">
								responding to emails/chat
							</li>
						</ul>
					</li>
					<li style="margin:0 0 5px 0; text-align:justify;">
						Meets or exceeds client-stipulated Key Responsibility Areas (KRAs) and Key Performance Indicators(KPIs) which may include either/ all of the following: Attendance and Adherence, Quality Assurance (QA), Sales quotas/ Conversion, Productivity, Call Handling Time, and/ or Customer Satisfaction (CSAT) /Customer Service Index (CSI).
					</li>
				</ul>
			</div>
			
			
			<div style="font-size:12px;letter-spacing:0.5px;color:#000;line-height:18px;margin:0 0 10px 0;">
				Interacts with customers and execute various tasks to increase level of customer experience such as but not limited to:
			</div>
			
			<div style="font-size:12px;letter-spacing:0.5px;color:#000;line-height:18px;margin:0 0 10px 0;">
				<ul style="margin:0 0 0 -15px;">
					<li style="margin:0 0 5px 0;">
						Providing appropriate resolutions
					</li>
					<li style="margin:0 0 5px 0;">
						following-through on responsibilities to customers and the business
					</li>
					<li style="margin:0 0 5px 0;">
						keeping records of customer interactions						
					</li>
					<li style="margin:0 0 5px 0;">
						processing customer accounts
					</li>
					<li style="margin:0 0 5px 0;">
						identifying opportunities to drive process improvements
					</li>
					<li style="margin:0 0 5px 0;">
						verify and validate customer files/documents						
					</li>
					<li style="margin:0 0 5px 0;">
						focusing on customer engagement
					</li>
					<li style="margin:0 0 5px 0;">
						Sends required reports set by the account and/ or immediate supervisor
					</li>
					<li style="margin:0 0 5px 0;text-align:justify;">
						Collaborates with immediate superior about learning opportunities, career pathing and job growth for professional development.
					</li>
				</ul>
			</div>
			
			
			
			<div style="font-size:12px;letter-spacing:0.5px;color:#000;line-height:18px;margin:0 0 10px 0;">
				<strong>Others</strong>
			</div>
			<div style="font-size:12px;letter-spacing:0.5px;color:#000;line-height:18px;margin:0 0 30px 0;text-align:center;">
				Performs related duties and responsibilities as may be assigned and requested by immediate superior.
			</div>
			
			<div style="font-size:12px;letter-spacing:0.5px;color:#000;line-height:18px;margin:0 0 30px 0;text-align:center;text-decoration:underline;">
				<strong>QUALIFICATIONS</strong>
			</div>
			
			<div style="font-size:12px;letter-spacing:0.5px;color:#000;line-height:18px;margin:0 0 20px 0;">
				<?php echo $can_dtl_row['qualification']; ?>
			</div>
			
			<div style="font-size:12px;letter-spacing:0.5px;color:#000;line-height:18px;margin:0 0 30px 0;text-align:center;text-decoration:underline;">
				<strong>
					This is to certify that I have read and understood this job description and promise to perform these duties and responsibilities to the best of my ability.
				</strong>
			</div>
			
			<div style="font-size:12px;letter-spacing:0.5px;color:#000;line-height:18px;margin:0 0 30px 0;">
				<div style="display:inline-block;color:#000;font-weight:bold;margin:50px 0 0 0;width:50%;float:left;">
					Job description discussed by:
				</div>
				<div style="display:inline-block;float:right;width:50%;">
					<div style="text-align:center;margin:3px 0 0 0;">
						<strong>Name and Signature</strong>
					</div>
					<div style="text-align:center;" id="signaturehead">
						<img src="./uploads/signatures/<?php echo $signature;?>" alt="">
						<!--<strong>BELLA FABRICANTE</strong><br>-->
						<div style="margin:-20px 0 0 0;">
							<strong>Head of Operations</strong>
						</div>
					</div>
				</div>
			</div>			
		</div>
	</div>



</body>
</html>