<!DOCTYPE html>
<html lang="en">

<head>
	<title>Letter Of Intent</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet"> </head>

<body>
	<div style="width:100%;">
		<div style="box-shadow: none;">
			<div style="padding: 5px 15px 15px 15px"> </div>
			<div style="position:relative;padding: 15px;">
				<div style="width: 100%;overflow-x: hidden;padding: 0 10px 0 0;">
					<div style="width:100%;padding-left: 20px;text-align: justify;">
						<div><img src="<?php APPPATH; ?>assets/images/fusion-bpo.png" alt="" style="height: 100px;"></div>
						<div style="width: 100%;margin: 20px 0px 20px 20px;">
							<div style="text-align: left;position: relative;margin-bottom: 40px;"><span><h5 >Date</h5></span><span style="height: 1px;display: inline-block;position: absolute;top: 14px;left: 32px;"><?php echo $issue_date; ?></span></div>
							<div style="text-align: left;position: relative;"><span><h5 >Name   :  <?php echo $fname.' '.$lname;?></h5></span><span style="width: 150px;display: inline-block;position: absolute;top: 14px;left: 42px;"></span></div>
							<div style="text-align: left;position: relative;"><span><h5 >Address : <?php echo $address; ?></h5></span><span style="width: 150px;display: inline-block;position: absolute;top: 14px;left: 50px;"></span></div>
							
						</div>
						<div style="width:100%; margin: 100px  0 0 0;">
							<div style="text-align: center;position: relative;"><span><h5 ><strong style="font-weight: bold;">Subject: Letter of Intent</strong></h5></span></div>
						</div>
						<div style="width:100%; margin: 40px  0 0 20px;">
							<div style="text-align: left;position: relative;"><span><h5 >Dear</h5></span><span style="width: 150px;height: 1px;display: inline-block;position: absolute;top: 14px;left: 32px;"><?php echo $fname.' '.$lname;?></span><span style="position: absolute;top: -2px;left: 184px;font-size: 15px;">,</span></div>
						</div>
						<div style="margin: 40px 0 10px 20px;">
						
							<p style="margin-bottom: 20px;"> This has reference to your application and interview with us; we are pleased to offer you an opportunity to attend our <strong style="font-weight: bold;">Specialized Training Program </strong>as per Company Scheme which is mandatory for the position of <strong style="font-weight: bold;">“<?php echo $can_dtl_row['position_name'];?>” </strong>. The Training Start Date is <?php echo $training_start_date; ?>.</p>
							
							<?php 
								if($can_dtl_row['emp_type']==6){
							?>	
								<p style="margin-bottom: 10px;">
								<b>This offer/apprenticeship will be valid for <?php echo $can_dtl_row['contract_dur_days'] ?> days, or it may get extended.</b>
								</p>
								
							<?php } ?>
							
							
							<p style="margin-bottom: 20px;">On successful completion and certification of Training for which the management is the sole judge, you will be absorbed as a<strong style="font-weight: bold;"> “<?php echo $can_dtl_row['position_name'];?>”</strong> at <?php echo $brand_name; ?>, <span style="width: 80px;height: 1px;display: inline-block;"><?php echo get_location_by_abbr($location); ?></span>  (Location) and your monthly <?php echo $ctc_type; ?> will be Rs.<span style="width: 100px;height: 1px;display: inline-block;"><?php echo number_format($ctc_amount,2) ; ?></span> /- (Rupees <span style="width: 200px;height: 1px;display: inline-block;"><?php echo ucwords(convertNumberToWord($ctc_amount));?></span> Only) with effect from the date of your completion and certification of training </p>
							<p style="margin-bottom: 20px;"> <strong style="font-weight: bold;">Validity</strong>- The validity of this letter is for Two Weeks from the date of issuance. </p>
							<p style="margin-bottom: 20px;"><strong style="font-weight: bold;">Shift Timing & Transfer -</strong>Please be notified that it is the sole discretion of the company to alter the shift timing /Inter process movement  in view of  the Business Requirement which shall be duly communicated by Training / respective Ops HOD along with the HR department.</p>
							<p style="margin-bottom:20px"><strong style="font-weight: bold;">Training Fee/Stipend During Training Period - </strong>Please be notified that the company will pay training fee/stipend of Rs.<span><?php echo number_format($stipend_amount,2); ?> /- </span>per day only on the Successful completion and certification of the training program. </p>
							<br/><br/>
							<p style="margin-bottom:10px;"><strong style="font-weight: bold;"> Payment of Training Stipend:</strong>  </p>
							<p style="margin-bottom: 5px;margin-left: 40px;"> (a)	If successfully certified in process training between 1st to 15th of the month, the training fees would be paid between 25 to 30th of same month. </p>
							<p style="margin-bottom: 20px;margin-left: 40px;">
								(b)	If successfully certified in process training between 16th to 30th of the month, the training fees would be paid between 15th to 20th of next month.
							</p>
							<p style="margin-bottom: 20px;"> Your Appointment letter will be issued to you after successful completion and Certification of   the Training. Management reserves the right for continuation/discontinuation of training. </p>
							<p style="margin-bottom: 20px;">We warmly welcome you to the<strong style="font-weight: bold;"> <?php echo $brand_name; ?> </strong>family and wish you a rewarding career with us. </p>
								<div style="margin-bottom: 20px; width: 100%;">
							<p> <strong style="font-weight: bold;">Joining Formalities –   </strong> </p>

						     </div>
							<div style="margin-bottom: 20px; width: 100%;">
								<p> You are required to carry the following documents at the time of your joining:  </p>
								<ol style="margin:-10px 0 0 -24px;">
									<li>Copy of all your educational certificates,  </li>
									<li>Accepted resignation letter of the last organization and last drawn salary slip (in original)  </li>
									<li>Salary bank statement of last six months  </li>
									<li>Appointment / experience letter of the last organization,  </li>
									<li>Passport size photographs-4, </li>
									<li>Passport Copy </li>
									<li>PAN Card Copy </li>
									<li>AADHAR Card Copy </li>
									<li>Proof of Residential address if address is different than Aadhar Card,</li>
									<li>Medical Fitness Certificate  </li>
									<li>Vaccination Certificate</li>
								</ol>
							</div>
							<p style="margin-bottom: 20px;"> Please note that if any declaration given or furnished by you to the company is found to be false or if you found to have willfully suppressed any material information; in such case, the offer/appointment made by us stands withdrawn without any notice/compensation.</p>
							<p style="margin-bottom: 40px;">Team HR , Fusion BPO <?php //echo $brand_name; ?> </p>
							<!-- <p style="margin-bottom: 40px;"><div><img src="<?php //APPPATH; ?>main_img/fusion_stamp.png" style="width: 100px;margin-left: 30px;"></div></p>
							<p style="margin-left: 20px;">Oindrila Banerjee</p>
							<p style="margin-bottom: 0px;"> <div style="width: 180px;height: 1px;background: #000;display: inline-block;"></div></p>
							<p style="margin-bottom: 40px;margin-left: 20px;"><strong>General Manager</strong></p> -->
							<p style="margin-bottom: 40px;">I hereby accept the terms and conditions of the letter and by my signature hereto, I bind myself to abide by them.</p>
							<p style="margin-bottom: 40px;"> Name & Signature of the candidate  <div style="margin-left: 200px;width: 400px;height: 1px;display: inline-block;background-color: #000;"></div> </p>
						</div>
					</div>
				</div>
			</div>
		</div>
</body>

</html>