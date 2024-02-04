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
				<td width='60%'> <img src='<?php echo base_url() ?>assets/images/fusion.png' height='100' width='150' border='0'></td>
				<td width="40%"><strong>Fusion BPO Service Ltd.<br>
					15 Old Hope Road<br>
					Kingston 5<br>
					Jamaica</strong>
				</td>				
			</tr>			
		</table>
		<br><br>
		<p><?php echo date("F d, Y"); ?></p>
		<p>Name : <?php echo $can_dtl_row['fname'].' '.$can_dtl_row['lname'] ?><br>
		Address 1 : <?php echo $can_dtl_row['address'] ?><br>
		Address 2</p>
		
		
		<p style="text-align:left; font-size:16px; font-weight:bold; text-decoration: underline;">Re: Job Offer – Customer Service Agent – Inbound HCCO</p>
		
		
		<p>Dear Ms. Employee:</p>
		<p>Fusion BPO Services Limited is pleased to extend this offer of employment for the position of Customer
Service Agent – Inbound HCCO</p>
		<p>If you accept this job offer, you will start this new post on <?php echo date( "F d, Y", strtotime($can_dtl_row['doj'])); ?> and will report directly to the
Team Lead and Operations Supervisor (HCCO). The current annual gross salary being offered is <?php echo ucwords(strtolower(numberTowords($can_dtl_row['gross_pay']))); ?> Dollars ($<?php echo $can_dtl_row['gross_pay'] ?>) which will be subjected to the relevant taxes.</p>
		<p>We would like a response to this offer of employment no later than <?php echo date( "l, F d, Y", strtotime($can_dtl_row['doj'])); ?>. In the
meantime, please feel free to contact the undersigned at email Karen.Adlam@fusionbposervices.com if you
have any queries relating to this employment.</p>
		<p>We are looking forward to having you on our team</p>
		
		<p>Yours truly</p>
		<p><strong>FUSION BPO SERVICES</strong></p>
		<br><br>
		<p><strong>--------------------------------<br>
			Karen Adlam (Ms.)<br>
			HR Generalist</strong></p>
		<br><br>
		<p><strong>Website:</strong> www.fusionbposervices.com</p>
		
		
		
	
		
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