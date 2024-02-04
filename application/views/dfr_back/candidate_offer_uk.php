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
		<!-- <p style="text-align:center;">
		<img src='<?php echo base_url() ?>assets/images/logoceb.png' height='100' width='150' border='0'></br>
		<span style='font-size:11px'>US: 1480 Vine Street | Suite 402 | Los Angeles | CA | 90028</span><br>
		<span style='font-size:11px'>PH: 7F Cybergate Bldg. | Fuente Osmeña | Cebu City | Cebu | PH | 6000</span><br>
		<span style='font-size:11px'>Phone: 310-734-8225 | Fax: 206-350-0106 | www.supportsave.com</span>
		</p> -->		
</br>
</br>
		
		<table cellpadding='2' cellspacing="0" border='0'  style='font-size:18px; text-align:left; width:100%;'>
			<tr>
				<td width='35%'></td>
				<td width="30%"><img src='<?php  echo base_url() ?>assets/images/fusion-bpo.png' height='100' width='150' border='0'> </td>
				<td width="35%"></td>				
			</tr>			
			<tr>
				<td width='35%'>Name: <?php  echo $can_dtl_row['fname'].' '.$can_dtl_row['lname']; ?></td>
				<td width="30%"></td>
				<td width="35%"><?php echo date("M, Y"); ?></td>				
			</tr>	
			<tr>
				<td width='35%'>Address: <?php echo $can_dtl_row['address']; ?></td>
				<td width="30%"></td>
				<td width="35%"></td>
			</tr>						
		</table>
		<br><br>
				
		<p style="text-align:left; font-size:16px; font-weight:bold; text-decoration: underline;">Offer Letter</p>		
		
		<p>Dear <?php echo $can_dtl_row['fname'].' '.$can_dtl_row['lname']; ?>,</p>
		<p>As mutually discussed, we are pleased to inform you on your new assignment in the position of <?php echo $can_dtl_row['position_name']; ?>, starting on  </p> <?php  echo $can_dtl_row['doj']; ?>. at Fusion BPO Services, under this terms and conditions:
		
		<p style="text-align:left; font-size:14px; font-weight:bold; text-decoration: underline;">1.	SALARY</p>		
		<p>Your salary will commence at EURO (€) <?php echo $can_dtl_row['gross_pay']; ?> gross per annum.</p>
		
		<p style="text-align:left; font-size:14px; font-weight:bold; text-decoration: underline;">2.	PROBATIONARY PERIOD</p>		
		<p>Your appointment will be subject of a probationary period of 3 months. Notice period post probation is 1 (one) month. </p>
		
		
		<p style="text-align:left; font-size:14px; font-weight:bold; text-decoration: underline;">3.	WORKING HOURS</p>		
		<p>Your standard working hours will be: 10:00am - to 5:00pm Monday to Friday, with a one-hour lunch break each day (working hours may change depending on company’s requirements).</p>
		
		
		<p style="text-align:left; font-size:14px; font-weight:bold; text-decoration: underline;">4.	HOLIDAYS</p>		
		<p>Holiday entitlement (including all bank and public holidays): 28 rising to 31 per annum after 1 year of employment.</p>
		
		
		<p style="text-align:left; font-size:14px; font-weight:bold; text-decoration: underline;">5.	COMPANY ADRESS</p>		
		<p>_______________________________________________ </p>
		
		
		<p>As an employee of Verso Group, you will be eligible for the benefits as per the company policy and UK Labor Codes. Please indicate your agreement with these terms and accept this offer by signing and dating this agreement on or before ________________, 2020.</p>
		<p>Sincerely yours</p>
		
		
		
		
		
	
		
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