<?php

$approved_on = date_format(date_create($can_dtl_row['approved_on']),'Y-m-d');
if ($can_dtl_row['approved_on'] =='' ) $approved_on = '';

$gross_pay = $can_dtl_row['gross_pay'];
$location = $can_dtl_row['location'];
$org_role = $can_dtl_row['org_role'];
$pay_type = $can_dtl_row['pay_type'];
$gender = $can_dtl_row['gender'];
$incentive_amt = $can_dtl_row['incentive_amt'];
$incentive_period = $can_dtl_row['incentive_period'];
$joining_bonus = $can_dtl_row['joining_bonus'];
$variable_pay = $can_dtl_row['variable_pay'];
$rank = $can_dtl_row['rank'];


if ($location == "") $location = $can_dtl_row['pool_location'];

$basic = get_basic($gross_pay, $location, $org_role);
$hra =  get_hra($basic, $location, $org_role);

$conveyance = get_conveyance($gross_pay, $location);
$other_allowance = get_allowance($gross_pay, $basic, $hra, $conveyance, $location);

$ptax = get_ptax($gross_pay, $location, $gender);

$pf = get_pf($basic, $location);

$gr_amt_esi =  $gross_pay - $conveyance;
$esi_employer = get_esi_employer($gr_amt_esi, $location, $gross_pay);
$esi_employee = get_esi_employee($gr_amt_esi, $location, $gross_pay);

if ($pay_type == "8") {
	$pf = 0;
	$esi_employer = 0;
	$esi_employee = 0;
}

$ctc = $gross_pay + $esi_employer + $pf;
$tk_home = round($gross_pay - ($pf + $esi_employee + $ptax));

if ($org_role == 13) $notice_period = '30';
else $notice_period = '90';
?>
	<div style="width:70%;font-family: 'Roboto', sans-serif;padding-right: 15px;padding-left: 15px;margin-right: auto;margin-left: auto;">
		<div style="box-shadow: 0 5px 15px rgba(0, 0, 0, 0.31);">
			<div style="padding: 5px 15px 15px 15px"> </div>
			<div style="position:relative;padding: 15px;">
				<div style="width: 100%;overflow-x: hidden;padding: 0 10px 0 0;">
					<div style="width:100%;padding-left: 20px;">
						<div><img src="img/fusion-logo.png" alt="" style="height: 100px;"></div>
						<div style="width: 100%;margin: 20px 0px 20px 20px;">
							<div style="text-align: left;position: relative;margin-bottom: 40px;"><span><h5 >Date</h5></span><span style="width: 150px;height: 1px;background: #000;display: inline-block;position: absolute;top: 14px;left: 32px;"></span></div>
							<div style="text-align: left;position: relative;"><span><h5 >Mr/Ms</h5></span><span style="width: 150px;border: 1px dashed #000;display: inline-block;position: absolute;top: 14px;left: 42px;"></span></div>
							<div style="text-align: left;position: relative;"><span><h5 ></h5></span><span style="width: 200px;height: 1px;background: #000;display: inline-block;position: absolute;top: 14px;left:0px;"></span></div>
							<div style="text-align: left;position: relative;margin-top: 40px;"><span><h5 ></h5></span><span style="width: 200px;height: 1px;background: #000;display: inline-block;position: absolute;top: 14px;left: 0;"></span></div>
						</div>
						<div style="width:100%; margin: 100px  0 0 0;">
							<div style="text-align: center;position: relative;"><span><h5 ><strong>Subject: Letter of Intent</strong></h5></span></div>
						</div>
						<div style="width:100%; margin: 40px  0 0 20px;">
							<div style="text-align: left;position: relative;"><span><h5 >Dear</h5></span><span style="width: 150px;height: 1px;background: #000;display: inline-block;position: absolute;top: 14px;left: 32px;"></span><span style="position: absolute;top: -2px;left: 184px;font-size: 15px;">,</span></div>
						</div>
						<div style="margin: 40px 0 10px 20px;">
							<p style="margin-bottom: 20px;"> This has reference to your application and interview with us; we are pleased to offer you an opportunity to attend our <strong>Specialized Training Program</strong> as per Company Scheme which is mandatory for the position of <strong>Customer Care Executive.</strong> </p>
							<p style="margin-bottom: 20px;"> On successful completion and certification of Training for which the management is the sole judge, you will be absorbed as a <strong>Customer Care Executive</strong> at Xplore-Tech Services Private Limited,<span style="width: 80px;height: 1px;background: #000;display: inline-block;"></span> <strong>(Location)</strong> and your monthly compensation (CTC – Cost to company) will be Rs.<span style="width: 80px;height: 1px;background: #000;display: inline-block;"></span>/- (Rupees<span style="width: 200px;height: 1px;background: #000;display: inline-block;"></span>_Only) with effect from the date of your completion and certification of training. </p>
							<p style="margin-bottom: 20px;"> <strong>Validity</strong> -This offer of appointment as <strong>Customer Care Executive</strong> is valid from the date of successful completion and certification of training. </p>
							<p style="margin-bottom: 20px;"> <strong>Transfer</strong> -Please be notified that it is the sole discretion of the company to alter the shift timing /Inter process movement in view of the Business Requirement which shall be duly communicated by Training / respective Ops HOD along with the HR department. </p>
							<p style="margin-bottom: 20px;"> <strong>Training Fee/Stipend During Training Period</strong> - Please be notified that the company will pay training fee/stipend &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; @ Rs.<strong style="background: yellow;padding: 2px;"> ……………(60 percent of offered CTC/30)</strong> per day only on the Successful completion and certification of the training program. </p>
							<p style="margin-bottom: 20px;"> Your detailed Appointment letter will be issued to you after successful completion and Certification of the Training. Management reserves the right for continuation/discontinuation of training. </p>
							<p style="margin-bottom: 20px;"> We warmly welcome you to the <strong>Xplore-Tech Services Private Limited </strong> family and wish you a rewarding career with us. </p>
							<p style="margin-bottom: 20px;"> <strong>Joining Formalities – </strong> </p>
							<div style="margin-bottom: 20px; width: 100%;">
								<p> You are required to carry the following documents at the time of your joining: </p>
								<ol style="margin:-10px 0 0 -24px;">
									<li>Copy of all your educational certificates, </li>
									<li>Accepted resignation letter of the last organization and last drawn salary slip (in original) </li>
									<li>Salary bank statement of last six months </li>
									<li>Appointment / experience letter of the last organization, </li>
									<li>Passport size photographs-4, </li>
									<li>Passport Copy </li>
									<li>PAN Card Copy </li>
									<li>AADHAR Card Copy </li>
									<li>Proof of Residential address if address is different than Aadhar Card, </li>
									<li>Medical Fitness Certificate </li>
									<li>Your joining will be confirmed post providing the Vaccination Document</li>
								</ol>
							</div>
							<p style="margin-bottom: 20px;"> Please note that if any declaration given or furnished by you to the company is found to be false or if you found to have willfully suppressed any material information; in such case, the offer/appointment made by us stands withdrawn without any notice/compensation. </p>
							<p style="margin-bottom: 40px;">For <strong>Xplore-Tech Services Private Limited</strong></p>
							<p style="margin-bottom: 40px;">Name & Designation
								<br> <strong>Authorized Signatory</strong> </p>
							<p style="margin-bottom: 40px;">I hereby accept the terms and conditions of the letter and by my signature hereto, I bind myself to abide by them.</p>
							<p style="margin-bottom: 40px;"> Name & Signature of the candidate <span style="width: 400px;height: 1px;background: #000;display: inline-block;"></span> </p>
						</div>
					</div>
				</div>
			</div>
		</div>
