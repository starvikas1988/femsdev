<?php

$approved_on = date_format(date_create($can_dtl_row['approved_on']), 'Y-m-d');
if ($can_dtl_row['approved_on'] == "") $approved_on = '';
$per_day_array = array(2, 3, 10, 11);

$gross_pay = $can_dtl_row['gross_pay'];

$location = $can_dtl_row['location'];
$org_role = $can_dtl_row['org_role'];
$pay_type = $can_dtl_row['pay_type'];
$emp_type = $can_dtl_row['emp_type'];

$payroll_type_name = $can_dtl_row['payroll_type_name'];
$incentive_amt = $can_dtl_row['incentive_amt'];
$incentive_period = $can_dtl_row['incentive_period'];
$joining_bonus = $can_dtl_row['joining_bonus'];
$variable_pay = $can_dtl_row['variable_pay'];
$rank = $can_dtl_row['rank'];

$doj = $can_dtl_row['doj'];
$contract_dur_days = $can_dtl_row['contract_dur_days'];

$term_end_date = date('Y-m-d', strtotime(date($doj) .' +'.$contract_dur_days.' day'));

$master_org_grade_id = $can_dtl_row['master_org_grade_id'];
$org_grade_id = $can_dtl_row['org_grade_id'];

if ($location == "") $location = $can_dtl_row['pool_location'];

	
	$brand = $can_dtl_row['company'];
	if($brand=="") $brand = $can_dtl_row['brand'];
	
	//$singDtls = get_signature_details($location, $org_role, $rank, $brand, $doj);
	$singDtls = get_signature_details($location, $org_role, $rank, $brand, $can_dtl_row['doj'],$master_org_grade_id);
	
	
	$for_comp = $singDtls['company'];
	$signature_text = $singDtls['signature_text'];
	$signature_img = $singDtls['signature_img'];

$ctc = $gross_pay;
$ctc_year = $gross_pay *12;

	
?>

<br><br><br>
<div style="width:100%;">

			<div style="font-size:16px;text-align: center;">
				<div style="margin: 0 0 5px 0;"><b>CONSULTING SERVICE AGREEMENT</b></div>
				<div style="margin: 0 0 5px 0;">Between </div>
				<div style="margin: 0 0 5px 0; font-weight: bold;"> <?php echo $can_dtl_row['fname'] . ' ' . $can_dtl_row['lname'] ?> </div>
				<div style="margin: 0 0 5px 0;">And</div>
				<div style="margin: 0 0 5px 0; font-weight: bold;"><?php echo $for_comp; ?></div>
				<div style="">
						Dated: 
						<?php 
							$brand_arr = array(12,1,2);
							if((in_array($brand, $brand_arr) && isIndiaLocation($location) == true && !empty($approved_on))){
							echo date('d-F-Y', strtotime($approved_on)); } else { echo $approved_on;}
						?>
					</div>
			</div>
			
			<br>
			<div style="font-size:14px; text-align: justify;">
				This Consulting Service Agreement is between <strong><?php echo $can_dtl_row['fname'] . ' ' . $can_dtl_row['lname'] ?></strong>, an Individual
				Consultant, hereinafter referred as “Consultant” and <?php echo $for_comp; ?> a company incorporated in Kolkata, India hereinafter referred to as "COMPANY".
			</div>
			<div style="font-size:14px;text-align:justify;">
				Consultant and Company shall be hereinafter individually referred to as “Party”, and collectively as “Parties”.
			</div>
			<br>
			<div style="font-size:14px;">
					<div> <strong>1. PROFESSIONAL SERVICES: </strong></div>
					<div style="">Consultant will provide services as <strong> <?php echo $can_dtl_row['position_name']; ?> </strong> on Fee basis, as mentioned hereinafter in this clause. </div>
					
					<div style=" text-align:justify;">During the term of this Agreement, Consultant shall have the
						right to pursue multiple contacts, affiliates and/or subsidiaries and/or divisions of the
						Customer/Clients that needs services on behalf of COMPANY on an exclusive basis. Consultant
						will make reasonable efforts to expand COMPANY's business to Customer/Client. COMPANY shall
						have the exclusive right to accept and/or reject any Customer/Client which has been
						represented by the Consultant to COMPANY without assigning any reasons to Consultant.
						Consultant reserves the right to be present at any and all face-to-face meetings or
						telephone conversations and conference calls between Company and Customer/Client. Consultant
						must submit information/documentation to Company for each Customer/Client, so that Company
						can have required information about all deals. The Consultant shall not do business with the
						customer/client.</div>
					<br>	
					<div style="">
						<b>Role & Responsibilities : <?php echo $can_dtl_row['position_name']; ?></b>
					</div>
					<br>
					<div>
					<strong>2. COMPENSATION:</strong><br>You shall be paid a “Professional Fee” of Rs. <strong><?php echo $ctc_year; ?>/-</strong>
					(Rupees <strong> <?php echo ucwords(convertNumberToWord($ctc_year)); ?> </strong> Only) annually out of which Rs.
					<strong><?php echo $ctc; ?>/-</strong> (Rupees <strong><?php echo ucwords(convertNumberToWord($ctc)); ?></strong> only)
					will be paid as fixed compensation which will be equally be distributed over 12 (Twelve) months for payment thereof.
					</div>
					<br>
					<div ><strong>3. TERM AND TERMINATION:</strong></div>
					<div style="">3.1. Term: </div>
					<div style=" text-align: justify;">
						This Agreement is commenced on <strong> <?php echo date('d-F-Y', strtotime($doj)); ?> </strong> and shall remain in effect for <strong> <?php echo $contract_dur_days ?> ( <?php echo ucwords(convertNumberToWord($contract_dur_days)); ?> ) </strong> days until <strong> <?php echo date('d-F-Y', strtotime($term_end_date)); ?> </strong> unless terminated by either party in writing as provided in Sections 3.2 or 3.3. At the end of the initial term the agreement may be mutually renewed for subsequent months. The terms and
						conditions will be mutually decided at the time of renewal.
					</div>
					<br>
					<div style="">3.2. Effect of Termination: </div>
					<div style=" text-align: justify;">
						Termination of this Agreement shall not limit either party from pursuing other remedies
						available to it, including injunctive relief, nor shall such termination relieve COMPANY of
						its obligation to pay all fees that have accrued or are otherwise owed by COMPANY hereunder.
						Both part'/s rights and obligations under the “Confidentiality” "Anti-Solicitation,"
						"Retention of Rights", "Limited Warranty; Remedies; Limitation of Liability', "General"
						Sections and this "Term and Termination" Section shall survive termination of this
						Agreement.
					</div>
					
					<div style="page-break-after: always"><span style="display: none;">&nbsp;</span></div>
					<br /><br /><br /><br />
							
						<div style=""><strong>4. GENERAL INDEMNITY:</strong></div>
						<div style="text-align: justify;">
							Each Party’s liability for any loss, cost. claim, injury, liability or expense, relating to
							or arising out of any act or omission in its performance of this Agreement shall be limited
							to the amount of direct damage actually incurred. Notwithstanding the provision above
							mentioned, Each Party ("Indemnifying Party") shall indemnify, protect, and hold harmless the
							Other Party ("Indemnified Party") from and against any loss, cost, claim, liability, damage
							or expense alleged by a third party, relating to or arising out of negligence or willful
							misconduct by the Indemnifying Party, its employees, agents or contractors in the
							performance of this Agreement. In addition, the Indemnifying Party, to the extent of its
							negligence or willful misconduct, shall defend any action or suit brought by a third party
							against the Indemnified Party for any loss, cost, claim, liability, damage or expense
							relating to or arising out of negligence or willful misconduct by the Indemnifying Party,
							its employees, agents or contractors, in the performance of this Agreement. The Indemnified
							Party shall notify the Indemnifying Party promptly, in writing, of any written claim,
							lawsuit or demand by third parties for which the Indemnified Party alleges that the
							Indemnifying Party is responsible under this paragraph to tender the defense of such claim,
							lawsuit or demand on behalf of the Indemnified Party.
						</div>
					
						<br>
						<div style=""><strong>5. LIMITATION OF LIABILITY:</strong></div>
						<div style="text-align: justify;">
							In no event shall either party be liable for any indirect, incidental, special or
							consequential damages, including without limitation damages for loss of profits, data or
							use, incurred by either party or any third party, whether in an action in contract or tort,
							even if the other party has been advised of the possibility of such damages. IT Consultant's
							aggregate and cumulative liability for damages hereunder shall not exceed the amount of fees
							paid by COMPANY under this Agreement, and if such damages result from COMPANY's use of the
							Services, such liability shall be limited to fees paid for the relevant Services giving rise
							to the liability. COMPANY's aggregate and cumulative liability for damages hereunder shall
							in no event exceed the amount of fees paid by COMPANY under this Agreement.
						</div>
					
						<br>
						<div style=""><strong>6. OWNERSHIP OF CUSTOMERS/CLIENTS:</strong></div>
						<div style="text-align: justify;">
							The parties acknowledge that all customers/Clients of the Consultant are and shall remain
							the property of the Company. If the Consultant shall cease to be associated with the Company
							for any reason, all such customer/Clients accounts must be smoothly handed over to the
							person designated by the Company for such transition
						</div>
					
						<br>
						<div style=""><strong>7. GENERAL PROVISIONS:</strong></div>
						<div style="margin: 0">7.1. Injunctive Relief:</div>
						<div style="text-align: justify;">
							Each of the parties agrees that if any of the provisions of this Agreement are breached, a
							remedy in law may be inadequate. Therefore, without limiting any other remedy available at
							law or equity, an injunction, specific performance or other form of equitable relief or
							money damages or any combination thereof shall be available to the non-breaching party. The
							non-breaching party shall be entitled to recover the cost of enforcing the understandings
							and agreements as reflected herein, including, without limitation, any attorneys’ fees
							incurred.
						</div>
						<br>
						<div style="margin: 0;">7.2. No Third Party Beneficiaries:</div>
						<div style="text-align: justify;">
							This Agreement is entered into for the parties' own behalf, on behalf of their respective
							subsidiaries and Representatives, and not for the benefit of any third party.
						</div>
					
					<div style="page-break-after: always"><span style="display: none;">&nbsp;</span></div>
					<br /><br /><br /><br />
					
						<div style="margin: 0;">7.3. Notices:</div>
						<div style="text-align: justify;">
							Any notice required or permitted to be sent hereunder must be in writing and sent in a
							manner requiring a signed receipt or if mailed, return receipt requested. Such notice can be
							copied via email to facilitate delivery, but must be followed in writing as prescribed
							above. Notice is effective upon receipt of written notice. Notice to each party will be made
							to the addresses set forth below.
						</div>
						<br>
						<div style="margin: 0;">7.4. Enforceability:</div>
						<div style="text-align: justify;">
							In the event any provision of this Agreement is held to be invalid or unenforceable, the
							remaining provisions of this Agreement will remain in full force.
						</div>
						<br>
						<div style="margin: 0;">7.5. Entire Agreement:</div>
						<div style="text-align: justify;">
							This Agreement, together with the attached exhibits, which are incorporated by reference,
							constitutes the complete agreement between the parties and supersedes any prior agreements,
							written or oral, between the parties relating to the subject matter hereof. No other act,
							document, usage or custom shall be deemed to amend or modify this Agreement unless agreed to
							in writing and signed by a duly authorized representative of both parties.
						</div>
						<br>
						<div style="margin: 0;">7.6 Confidentiality:</div>
						<div style="text-align: justify;">
							Consultant understands and acknowledges that during relationship with this Company,
							Consultant shall undergone use of, acquiring and/or adding to Company's Confidential
							Information (as defined below). In order to protect the Confidential Information, Consultant
							will not at any time after the date of termination of this agreement, in any way utilize or
							disclose any of the Confidential Information, whether for Consultant' own benefit or the
							benefit of any person or entity except the Company. The term "Confidential Information"
							shall mean any information that is confidential and proprietary to the Company, or of others
							that do business with Company that Company has received or may receive, including but not
							limited to the following general categories: (i) trade secrets; (ii) lists and other
							information about current and prospective customers; (iii) plans or strategies for sales,
							marketing, business development, or system build-out; (iv) sales and account records; (v)
							prices or pricing strategy or information; (vi) current and proposed advertising and
							promotional programs; (vii) engineering and technical data; (viii) methods, systems,
							techniques, procedures, designs, formulae, inventions and know-how; (ix) personnel
							information; (x) legal advice and strategies; and (xi) other information of a similar nature
							not known or made available to the public (other than by breach of this Agreement).
							Confidential Information includes any such information that Consultant prepared or created
							during his Consultancy, engagement or position with the Company, as well as such information
							that has been or may be created or prepared by others. This promise of confidentiality is in
							addition to any common law or statutory rights of the Company to prevent disclosure of its
							trade secrets and/or confidential information.
						</div>
						<div style="text-align: justify;">
							The obligations of confidentiality and use with respect to Confidential Information shall
							exist during the term of this Agreement, and shall survive after termination of this
							Agreement for a period of 2 (Two) years from the date of termination of this
							agreement.
						</div>
						<br>
						<div style=""><strong>8. HOURS: </strong></div>
						<div style="text-align: justify;">
							Consultant shall have to work minimum <b>5/9 hours </b> per day. The Consultant may be
							required to attend office meetings or office training sessions if required.
						</div>
					
					<div style="page-break-after: always"><span style="display: none;">&nbsp;</span></div>
						<br /><br /><br /><br />
						<br>
						<div style=""><strong>9. PLACE OF WORK: </strong></div>
						<div style="text-align: justify;">
							The Consultant shall have to work in <b>“<?php echo $can_dtl_row['location_name']; ?>”</b> of India for the work to be performed, is not required to work on the premises of the Company, but to answer the phones of the Company
							and/or relevant Client/Customer or perform any other duties at the Company’s office whenever
							required for performing under a deal or any other purpose.
						</div>
					
						<br>
						<div style=""><strong>10. GOVERNING LAW: </strong></div>
						<div style="text-align: justify;">
							The validity and interpretation of this Agreement will be governed by the law of India as applicable. The courts of Kolkata, India will be the exclusive jurisdiction without any conflict. 
						</div>
						
						
						
						
					<br><br>
				<div style="font-size:16px; text-align:justify;text-align: center;">
					<strong>Schedule 1 — Restrictive Covenants</strong>
				</div>
				<br>
				<div style="font-size:14px;text-align:justify;">
					
							<div style=""><strong>1. INTERPRETATION: </strong></div>
							<div style="text-align: justify;">
								The definitions and rules of interpretation in this clause apply in this agreement.
							</div>
							<br>
							<div style="text-align: justify;">
								<b>Restricted Business:</b> those parts of the business of the Company with which Consultant
								was involved to a material extent in the Twenty Four (24) months before Termination.
							</div>
							<br>
							<div style="text-align: justify;">
								<b>Restricted Customer: </b> any firm, company or person who, during the Twenty Four (24) months
								before Termination, was a customer or prospective customer of the Company with whom the
								Consultant had contact or about whom he became aware or informed in the course of his
								Agreement.
							</div>
							<br>
							<div style="text-align: justify;">
								<b>Restricted Person:</b> anyone employed or engaged by the Company and who could materially
								damage the interests of the Company if they were involved in any Capacity in any
								business concern which competes with any Restricted Business and with whom the of
								Consultant dealt in the Twenty Four (24) months before Termination in the course of his
								Agreement.
							</div>
							<br>
							<div style=""><strong>2. NON- COMPETE :</strong></div>
							
							<div style="text-align: justify;">
								During this Agreement and continuing for five (5) years after the termination of this
								Agreement, Consultant shall not directly or indirectly engage in, own, manage, operate
								or control, as an employee, operator, or director, partner, manager, consultant, agent,
								owner, or in any other capacity, any business similar to this Company's or that would
								have the direct or indirect effect of competing with Company's operations within any
								city, parish, municipality, or similar division where Consultant produces, sells, or
								markets its goods and services. Examples of prohibited competition include, without
								limitation, providing Employee's money, advice, or other support to any of Company's
								competitors.
							</div>
							<br>
							<div style=""><strong>3. NON-SOLICITATION :</strong></div>
							<div style="text-align: justify;">
								During the performance of the services hereunder and for twenty-four (24) months
								thereafter, Consultant agrees not to directly or indirectly, entice or solicit any
								customer/Client, employee, manager, consultant, or independent contractor, vendor of the
								company for any purpose whatsoever, whether for either party's benefit or the benefit of
								a third party. Consultant agrees to refrain from directly or indirectly solicit or
								endeavor to entice away from the Company the existing and pipeline business or customer
								and/or any end user customer or a Restricted Customer and/or end user Restricted
								customer with a view to providing goods or services to that Restricted Customer in
								competition with any Restricted Business.
							</div>
							<div style="page-break-after: always"><span style="display: none;">&nbsp;</span></div>

        <br /><br /><br /><br />
		
							<br>
							<div style=""><strong>4. NON-INTERFERENCE :</strong></div>
							<div style="text-align: justify;">
								Consultant hereby agrees that for a period of two (2) years commencing on the
								Termination Date, will not, directly or indirectly, for the benefit of Consultant or any
								other person or entity: (i) encourage, or induce any contractor, agent, supplier or the
								like to terminate its/his/her relationship (contractual or otherwise) with Company (in
								whole or in part), or to refrain from entering into a relationship (contractual or
								otherwise) with Company, (ii) interfere or attempt to interfere with the Company's
								relationship with any employee, independent contractor, Employee, agent, supplier, or
								vendor of the Company; or (iii) employ or otherwise engage as an employee, independent
								contractor or otherwise, or solicit for employment or engagement, any employee of
								Company. Consultant hereby agrees after termination of this agreement he will never
								represent himself as connected with the Company in any Capacity, other than as a former
								Employee, or use any registered names or trading names associated with the Company.
							</div>
						
				</div>
				<br>
				<div style="font-size:14px; text-align:justify;">
					IN WITNESS WHEREOF, the parties have caused their duly authorized representatives, and the
					undersigned represents that he or she is duly authorized, to execute this Agreement as of the later
					of the below dates.
				</div>
				<br>
				<br>
				
			<table cellpadding='0' cellspacing="0" border='0' align='center' style='font-weight:bold; width:100%;padding-top:40px;'>
            <tr>
                <td>
                    <span>Congratulations and best wishes,</span>
                </td>
            </tr>
            <tr>
                <td style="height:30px;">For <?php echo $for_comp; ?></td>
                <td style="height:30px;">I hereby accept the above agreement<br /></td>
            </tr>
            <tr>
                <td style="height:80px;">

                    <?php echo $signature_img; ?>
					
                    <br />
                </td>
                <td style="height:80px;">Signature:......................................................<br /><br /></td>
            </tr>
            <tr>
                <td style="height:30px;">

                    <?php echo $signature_text; ?>

                </td>
                <td style="height:30px;">Name:.............................................................</td>
            </tr>
        </table>
	</div>
</div>
