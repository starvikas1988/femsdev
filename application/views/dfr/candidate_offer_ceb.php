<?php
	/*
	$gross_pay = $can_dtl_row['gross_pay'];
	$location = $can_dtl_row['location'];
	if($location=="") $location = $can_dtl_row['pool_location'];
	
	$basic = get_basic($gross_pay, $location);
	$hra =  get_hra($basic, $location);
	
	$conveyance = get_conveyance($gross_pay, $location);
	$other_allowance = get_allowance($gross_pay, $basic, $hra,$conveyance, $location);
	
	$pf = get_pf($gross_pay, $location);
	$ptax = get_ptax($gross_pay, $location);
	
	$esi_employer = get_esi_employer($gross_pay, $location);
	$esi_employee = get_esi_employee($gross_pay, $location);
	
	$ctc = $gross_pay + $esi_employer + $pf;
	$tk_home = round($gross_pay - ($pf + $esi_employee + $pf ));
	*/
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

					
<div id="body1" style='width:52%; padding-left:10px;'>
		<p style="text-align:center;">
		<img src='<?php echo base_url() ?>assets/images/logoceb.png' height='100' width='150' border='0'></br>
		<span style='font-size:11px'>US: 1480 Vine Street | Suite 402 | Los Angeles | CA | 90028</span><br>
		<span style='font-size:11px'>PH: 7F Cybergate Bldg. | Fuente Osmeña | Cebu City | Cebu | PH | 6000</span><br>
		<span style='font-size:11px'>Phone: 310-734-8225 | Fax: 206-350-0106 | www.supportsave.com</span>
		</p>		
</br>
</br>
	
		<table cellpadding='2' cellspacing="0" border='1' align='center' style='font-size:12px; text-align:center; width:80%;'>
			<tr>
				<td><strong>JOB HOLDER</strong></td>
				<td><strong>:</strong></td>
				<td></td>
			</tr>
			<tr>
				<td><strong>POSITION TITLE</strong></td>
				<td><strong>:</strong></td>
				<td>Dedicated Representative - Customer Service</td>
			</tr>
			<tr>
				<td><strong>JOB LEVEL</strong></td>
				<td><strong>:</strong></td>
				<td>N/A</td>
			</tr>
			<tr>
				<td><strong>DIVISION</strong></td>
				<td><strong>:</strong></td>
				<td>N/A</td>
			</tr>
			<tr>
				<td><strong>DEPARTMENT</strong></td>
				<td><strong>:</strong></td>
				<td>Operations</td>
			</tr>
			<tr>
				<td><strong>SECTION</strong></td>
				<td><strong>:</strong></td>
				<td>N/A</td>
			</tr>
			<tr>
				<td><strong>UNIT</strong></td>
				<td><strong>:</strong></td>
				<td>N/A</td>
			</tr>
			<tr>
				<td><strong>IMMEDIATE SUPERIOR</strong></td>
				<td><strong>:</strong></td>
				<td>Team Lead / Operations Manager / Account Supervisor</td>
			</tr>
			<tr>
				<td><strong>COORDINATES WITH</strong></td>
				<td><strong>:</strong></td>
				<td>N/A</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td><strong>&nbsp;</strong></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td><strong>OVERSEES</strong></td>
				<td><strong>:</strong></td>
				<td>N/A</td>
			</tr>
		</table>
		<br>
		<p style="border: 2px solid; border-radius: 1px; text-align:center; font-size:20px; font-weight:bold;">
		JOB SUMMARY</p>
		<p style="font-size:18px;">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; The <strong>Dedicated Representative - Customer Service</strong> agent upholds organizational and account performance standards. He/She is responsible for all customer-related activities and accomplishes all required key performance metrics, goals, targets and tasks specified by the business and/or by the client. He/She represents the organization and the client in all channels of customer interactions dictated by account’s operational processes.
		</p>
		<p style="border: 2px solid; border-radius: 1px; text-align:center; font-size:20px; font-weight:bold;">
		JOB DUTIES & RESPONSIBILITIES</p>
		<p style=" font-size:18px;">
		These tasks are subject to change depending on the nature of service of the division/department or business direction.</p>
		<p style="font-size:18px;">
		&#9679; &nbsp;&nbsp;&nbsp;	Communicates and interprets customers’ needs by delivering professional, courteous and quality service before, during, and after customer interaction through multiple channels dependent on account-specific operations such as:</p>
		<p style="text-align:center; font-size:18px;">
			&#9675; &nbsp;&nbsp;&nbsp;	Phone<br>
			&#9675; &nbsp;&nbsp;&nbsp;	Email&nbsp;&nbsp;<br>
			&#9675; &nbsp;&nbsp;&nbsp;	Chat&nbsp;&nbsp;&nbsp;
		</p>
		<p style="font-size:18px;">
		&#9679; &nbsp;&nbsp;&nbsp;	Ensures the accuracy and confidentiality of all customer-related information such as but not limited to: account information, credit card details, billing information, <font color="red">customer identification</font>
		<br>
		&#9679; &nbsp;&nbsp;&nbsp;	Adheres to account-specific standard procedures, guidelines and policies concerning customer interaction and communication.
		<br>
		&#9679; &nbsp;&nbsp;&nbsp;	Meets or exceeds client-stipulated Key Responsibility Areas (KRAs) and Key Performance Indicators(KPIs) which may include either/all of the following: Attendance and Adherence, Quality Assurance (QA), Sales quotas/Conversion, Productivity, Call Handling Time, and/or Customer Satisfaction (CSAT)/Customer Service Index (CSI).
		<br>
		&#9679; &nbsp;&nbsp;&nbsp;	Interacts with customers and executes various tasks to increase level of customer experience such as but not limited to:
		<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&#9675; &nbsp;&nbsp;&nbsp;	providing appropriate resolutions		
		<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&#9675; &nbsp;&nbsp;&nbsp;	following-through on responsibilities to customers and the business
		<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&#9675; &nbsp;&nbsp;&nbsp;	keeping records of customer interactions
		<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&#9675; &nbsp;&nbsp;&nbsp;	processing customer accounts
		<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&#9675; &nbsp;&nbsp;&nbsp;	identifying opportunities to drive process improvements
		<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&#9675; &nbsp;&nbsp;&nbsp;	verify and validate customer files/documents 
		<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&#9675; &nbsp;&nbsp;&nbsp;	focusing on customer engagement
		<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&#9675; &nbsp;&nbsp;&nbsp;	<font color="red">actively listening and addressing the customer’s concern</font>
		<br>
		&#9679; &nbsp;&nbsp;&nbsp;	Sends required reports set by the account and/or immediate supervisor.
		<br>
		&#9679; &nbsp;&nbsp;&nbsp;	Collaborates with immediate superior about learning opportunities, career pathing and job growth for professional development.
		
		<p style="font-size:20px; font-weight:bold;">Others</p>
		<p style="font-size:18px; font-weight:bold;">&nbsp;&nbsp;&nbsp; Performs related duties and responsibilities as may be assigned and requested by immediate superior.</p>
		<p style="border: 2px solid; border-radius: 1px; text-align:center; font-size:20px; font-weight:bold;">
		QUALIFICATIONS</p>
		<p style="font-size:18px;">
		&#9679; &nbsp;&nbsp;&nbsp;	College graduate of any 4-year course with BPO-IT experience or College level of any 4-year course with at least 6 months BPO-IT support experience
		<br>
		&#9679; &nbsp;&nbsp;&nbsp;	Excellent interpersonal and English communication skills: Verbal and Written
		<br>
		&#9679; &nbsp;&nbsp;&nbsp;	Attentive to details and works with precision
		<br>
		&#9679; &nbsp;&nbsp;&nbsp;	Displays excellent judgment, reasoning and analytical skills
		<br>
		&#9679; &nbsp;&nbsp;&nbsp;	Proficient in basic software applications such as: Microsoft Office
		<br>
		&#9679; &nbsp;&nbsp;&nbsp;	Typing Speed of at least 30 wpm
		<br>
		&#9679; &nbsp;&nbsp;&nbsp;	Able to maintain confidentiality, credibility and professionalism
		<br>
		&#9679; &nbsp;&nbsp;&nbsp;	Open to working flexible shifts in the evening and during holidays
		<br>
		<font color=red>&#9679; &nbsp;&nbsp;&nbsp;	<span style="-webkit-text-decoration-line: line-through; text-decoration-line: line-through; color:red; ">Able to maintain confidentiality, credibility and professionalism</span> - DUPLICATE</font>
		<p style="font-size:19px; font-weight:bold;">
		This is to certify that I have read and understood this job description and promise to perform these duties and responsibilities to the best of my ability.
		<p>
		
		<br><br><br>
		<p style="text-align:right; font-size:19px; font-weight:bold;">
		_____________________________<br>
		Name and Signature  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		</p>
		
		<br><br>
		
		<p style="text-align:left; font-size:19px; font-weight:bold;">
		Job description discussed by:
		</p>
		<br><br>
		
		<p style="text-align:right; font-weight:bold;">
		<span style="font-size:10; -webkit-text-decoration-line: overline; text-decoration-line: overline;">(Signature above printed name & position)&nbsp;&nbsp;&nbsp;&nbsp;</span><br>
		<span style="font-size:14; font-weight:bold;">Manager  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
		</p>
		
		<br>
		<br>
		<br>
		<br>
		<br>
		
		</p>
		
		
		<br>
		<br>


<center>
	<p><span style='font-size:12px'>Issued by:  HR Organizational Development</span></p>
</center>

</div>

					
					
				</div>
			</div>
		</div>
		
		
	</section>
</div>	