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
	
	//echo'<pre>';print_r($can_dtl_row);die();
?>

<div class="wrap">
	<section class="app-content">
						
		<div class="row">
			<div class="col-md-12">
				<div class="widget">
				<header>
					<div style="width:700px;max-width:100%;margin:0 auto;">
						<div style="width:100%">
							<!--<img src="images/header.jpg" style="max-width:100%;" alt="">-->
						</div>
					</div>
				</header>
				<br><br><br>
				<div style="width:700px;max-width:100%;margin:50px auto;">
					<div style="width:100%">
						<div style="display:inline-block;width:auto;font-family: 'Open Sans', sans-serif;font-size:18px;color:#000;padding:0;margin:0;font-weight:bold;">
							Ref No: CSPL/ HR/ 2021
						</div>
						<div style="display:inline-block;width:auto;float:right;font-family: 'Open Sans', sans-serif;font-size:18px;color:#000;padding:0;margin:0;font-weight:bold;">
							Date:<?php echo date("d/m/Y") ?>
						</div>			
					</div>
					<div style="width:100%;margin:40px 0 0 0;">
						<div style="display:inline-block;width:auto;font-family: 'Open Sans', sans-serif;font-size:18px;color:#000;padding:0;margin:0;font-weight:bold;">
							Mr/Ms/Miss. <?php echo ucwords($can_dtl_row['fname']).' '.ucwords($can_dtl_row['lname']) ?><br>
							<?php echo $can_dtl_row['address'];?><br>
							
						</div>
					</div>
					
					<div style="width:100%;margin:40px 0 0 0;">
						<div style="display:inline-block;width:auto;font-family: 'Open Sans', sans-serif;font-size:18px;color:#000;padding:0;margin:0;font-weight:bold;">
							Dear <?php echo ucwords($can_dtl_row['fname']);?>(First Name),<br>				
						</div>
					</div>
					
					<div style="width:100%;margin:40px 0 0 0;">
						<div style="font-family: 'Open Sans', sans-serif;font-size:16px;letter-spacing:0.5px;color:#000;padding:0;margin:0;font-weight:normal;margin:0 0 15px 0;">
							This is in the reference to our discussion and interview had with you, we are pleased to offer you employment with <strong>Competent Synergies Pvt</strong>. Ltd. on the following terms and conditions: 				
						</div>
						<div style="font-family: 'Open Sans', sans-serif;font-size:16px;letter-spacing:0.5px;color:#000;padding:0;margin:0;font-weight:normal;margin:0 0 15px 0;">
							1.	You will be designated as <b><?php echo $can_dtl_row['position_name'];?></b> and <b><?php echo $can_dtl_row['department_name'];?></b> <strong>(Designation & Department).</strong>	
						</div>
						<div style="font-family: 'Open Sans', sans-serif;font-size:16px;letter-spacing:0.5px;color:#000;padding:0;margin:0;font-weight:normal;margin:0 0 15px 0;">
							2.	Your monthly Gross salary will be <strong>Rs.</strong> <?php echo $can_dtl_row['gross_pay'];?>/- <strong>(Rupees  <?php echo $pay_text;?></strong> <strong>Only)</strong>.
						</div>
						<div style="font-family: 'Open Sans', sans-serif;font-size:16px;letter-spacing:0.5px;color:#000;padding:0;margin:0;font-weight:normal;margin:0 0 15px 0;">
							3.	You will be based at one of our location at  <?php echo $can_dtl_row['location_name'];?><strong>(Location).</strong>
						</div>
						<div style="font-family: 'Open Sans', sans-serif;font-size:16px;letter-spacing:0.5px;color:#000;padding:0;margin:0;font-weight:normal;margin:0 0 15px 0;">
							4.	Your date of joining will be on or before <?php echo ($can_dtl_row['doj']=='0000-00-00')?'__________________':date('d/m/y',strtotime($can_dtl_row['doj']));?><strong>(Date of Joining)</strong>
						</div>
						<div style="font-family: 'Open Sans', sans-serif;font-size:16px;letter-spacing:0.5px;color:#000;padding:0;margin:0;font-weight:normal;margin:0 0 15px 0;">
							5.	Your employment would be subject to a positive Reference Check. 
						</div>
						<div style="font-family: 'Open Sans', sans-serif;font-size:16px;letter-spacing:0.5px;color:#000;padding:0;margin:0;font-weight:normal;margin:0 0 15px 0;">
							6.	Your appointment letter along with employment terms & conditions will be issued to you at the time of         your joining.
						</div>
						<div style="font-family: 'Open Sans', sans-serif;font-size:16px;letter-spacing:0.5px;color:#000;padding:0;margin:0;font-weight:normal;margin:0 0 15px 0;">
							7.	Please bring the below listed documents/details on your day of joining.
							<ul>
								<li style="font-family: 'Open Sans', sans-serif;font-size:16px;letter-spacing:0.5px;color:#000;padding:0;margin:0;font-weight:normal;margin:0 0 10px 0;">
									Date of Birth proof certificate (Copy of Passport/Birth certificate/Matriculation certificate) 
								</li>
								<li style="font-family: 'Open Sans', sans-serif;font-size:16px;letter-spacing:0.5px;color:#000;padding:0;margin:0;font-weight:normal;margin:0 0 10px 0;">
									Academic certificates & Relieving Letter/Resignation acceptance letter from previous employer.
								</li>
								<li style="font-family: 'Open Sans', sans-serif;font-size:16px;letter-spacing:0.5px;color:#000;padding:0;margin:0;font-weight:normal;margin:0 0 10px 0;">
									Proof of compensation-Salary Slip/Appointment Letter/Appraisal letter of previous employment
								</li>
								<li style="font-family: 'Open Sans', sans-serif;font-size:16px;letter-spacing:0.5px;color:#000;padding:0;margin:0;font-weight:normal;margin:0 0 10px 0;">
									Three passport size photographs
								</li>
								<li style="font-family: 'Open Sans', sans-serif;font-size:16px;letter-spacing:0.5px;color:#000;padding:0;margin:0;font-weight:normal;margin:0 0 10px 0;">
									Identity & Residence proof: Pan Card/Passport/Driving License/Ration Card/Voter Card/ Aadhar Card
								</li>
							</ul>
						</div>
						<pagebreak> 
						<br><br><br>
						<div style="font-family: 'Open Sans', sans-serif;font-size:16px;letter-spacing:0.5px;color:#000;padding:0;margin:0;font-weight:normal;margin:30px 0 15px 0;">
							Kindly sign the duplicate copy of this letter as a token of your acceptance.
						</div>
						<div style="font-family: 'Open Sans', sans-serif;font-size:16px;letter-spacing:0.5px;color:#000;padding:0;margin:0;font-weight:normal;margin:15px 0 15px 0;">
							Looking forward to a long and mutually beneficial association with us!
						</div>
						<div style="font-family: 'Open Sans', sans-serif;font-size:16px;letter-spacing:0.5px;color:#000;padding:0;margin:0;font-weight:normal;margin:15px 0 15px 0;">
							<strong>For Competent Synergies Private Limited.</strong>
						</div>			
					</div>
					
					<div style="width:100%;margin:90px 0 110px 0;">
						<div style="display:inline-block;width:auto;font-family: 'Open Sans', sans-serif;font-size:18px;color:#000;padding:0;margin:0;font-weight:bold;float:left; width:45%;">
							Authorised Signatory
						</div>
						
						<div style="display:inline-block;width:auto;float:right;font-family: 'Open Sans', sans-serif;font-size:18px;color:#000;padding:0;margin:0;font-weight:bold;width:45%;">
							Acceptance of Candidate<br>
							(Name of candidate)
						</div>
					</div>
					
				</div>
				
				<footer>
					<div style="width:700px;max-width:100%;margin:0 auto;">
						<div style="width:100%">
							<!--<img src="images/footer.jpg" style="max-width:100%;" alt="">-->
						</div>
					</div>
				</footer>
					
				</div>
			</div>
		</div>
		
	</section>
</div>	
