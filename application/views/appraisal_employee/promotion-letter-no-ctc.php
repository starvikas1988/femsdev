<?php 

	// $location = $individual_user['office_id'];
	// $gross_pay = $individual_user['gross_pay'];
	// $sex = $individual_user['sex'];
	// $pay_type= $individual_user['payroll_type'];
	
	// $basic = get_basic($gross_pay, $location , $individual_user['org_role_id']);
	// $hra =  get_hra($basic, $individual_user['office_id'], $individual_user['org_role_id']);
	
	
	// $conveyance = get_conveyance($gross_pay, $location);
	// $other_allowance = get_allowance($gross_pay, $basic, $hra,$conveyance, $location);
	// $ptax = get_ptax($gross_pay, $location, $sex);
	
	// $pf = get_pf($basic, $location);
	
	// $esi_employer = get_esi_employer($gross_pay, $location);
	// $esi_employee = get_esi_employee($gross_pay, $location);
	
	// if($pay_type=="8"){
	// 	$pf=0;
	// 	$esi_employer=0;
	// 	$esi_employee=0;
	// }
	
	// if($pay_type == "2" || $pay_type == "3" || $pay_type == "4" || $pay_type == "5" || $pay_type == "6" || $pay_type == "7"){
	// 	$pf=0;
	// 	$esi_employer=0;
	// 	$esi_employee=0;
	// }
	
	// $ctc = $gross_pay + $esi_employer + $pf;
	// $annual_ctc = $ctc * 12;
	// $tk_home = round($gross_pay - ($pf + $esi_employee + $ptax ));

	// print_r($individual_user);
	
	 $datedoj = $individual_user['doj']; 

	 $incentive_amt = $individual_user['incentive_amt'];
	$incentive_period = $individual_user['incentive_period'];
	$joining_bonus = @$individual_user['joining_bonus'];
	$rank = $individual_user['rank'];
	 
	 $date 	= date_create($datedoj);
				
	 $doj = date_format($date,"Y-m-d");
	 
	 $current_date  = date('Y-m-d');
	 $event_date=$individual_user['event_date']!=''?date_format(date_create($individual_user['event_date']),'Y-m-d'):'';
	
		
	$office_id = $individual_user['office_id'];
	$org_role = $individual_user['org_role_id'];
	
	$rank = $individual_user['rank'];
	$brand = $individual_user['brand'];
	$master_org_grade = $individual_user['master_org_grade'];
	
	// "company" => $for_comp,
	// "signature_text" => $signature_text,
	// "signature_img" => $signature_img
		
	$singDtls = get_signature_details($office_id, $org_role, $rank, $brand, $individual_user['doj'],$master_org_grade);
	$for_comp = $singDtls['company'];
	$signature_text = $singDtls['signature_text'];
	$signature_img = $singDtls['signature_img'];
 ?>
	<br><br>
	<div style="width:100%;">

		
		<section id="pdf-converter" class="pdf-converter">
			<div style="width:800px;margin:0 auto;max-width:100%;">
				
				<?php 
				$datedoj = $individual_user['doj']; 
	 
	 			$date = date_create($datedoj); 
	 			?>				
				
				<p style="font-size:14px;font-family: 'Roboto', sans-serif;	padding:0 0 15px 0;margin:60px 0 0 0;line-height:25px;">
					Date: <?php echo $event_date; ?>
				</p>
				<p style="font-size:14px;font-family: 'Roboto', sans-serif;	padding:0 0 15px 0;margin:0 0 0 0;line-height:25px;">
					Name: <?php echo $individual_user['fname'].' '. $individual_user['lname']; ?><br>
					Employee Code: <?php echo $individual_user['fusion_id']; ?><br>
					<?php echo $for_comp; ?><br>
				</span>
				</p>
				<p style="font-size:14px;font-family: 'Roboto', sans-serif;	padding:0 0 15px 0;margin:0;line-height:25px;font-weight:bold; text-align:center">
					Sub:- <u>Promotion Letter</u>
				</p>
				<p style="font-size:14px;font-family: 'Roboto', sans-serif;	padding:0 0 15px 0;margin:0;line-height:25px;">
					Dear <?php echo $individual_user['fname'].' '. $individual_user['lname']; ?>,
				</p> 
				<p style="font-size:14px;font-family: 'Roboto', sans-serif;	padding:0 0 15px 0;margin:0;line-height:25px;">
					On behalf of <?php echo $for_comp; ?>, we are pleased to inform you that</br>
					based on your annual performance you have been promoted to the <?php echo $role['name']; ?>-Role effective Date <?php echo $individual_user['affected_from']; ?>.<br>

					<?php if($incentive_amt > 0 || $joining_bonus > 0){ ?>
					<span style='font-size:15px; font-weight:bold; '>ADDITIONAL REMUNERATION: </span>
					<span> <?php if($incentive_amt > 0) echo "$incentive_period Incentive Amount: Rs.". number_format($incentive_amt,2)."(".getIndianCurrency($incentive_amt).")"; if($joining_bonus > 0) echo " Joining Bonus: Rs. ".number_format($joining_bonus)."(".getIndianCurrency($joining_bonus).")"; ?></span><br>
				<?php } ?>
					
				</span>
				</p>


				


				<p style="font-size:14px;font-family: 'Roboto', sans-serif;	padding:0 0 15px 0;margin:0;line-height:25px;">
					All other terms and conditions pertaining to your employment with us remain unchanged.
				</p>
				<p style="font-size:14px;font-family: 'Roboto', sans-serif;	padding:0 0 15px 0;margin:0;line-height:25px;">
					Please note this position is subjected to your performance in the new role.
				</p>

				<p style="font-size:14px;font-family: 'Roboto', sans-serif;	padding:0 0 15px 0;margin:0;line-height:25px;">
					Congratulations and best wishes,
				</p>
				
				<p style="font-size:14px;font-family: 'Roboto', sans-serif;	padding:0 0 15px 0;margin:0;line-height:25px;">
					Regards,
				</p>

				<p style="font-size:14px;font-family: 'Roboto', sans-serif;	padding:0 0 15px 0;margin:0;line-height:25px;">
					Yours truly,  
				</p>
				
				<p style="font-size:14px;font-family: 'Roboto', sans-serif;	padding:0 0 15px 0;margin:0;line-height:25px;">
				
					<?php echo "For " . $for_comp; ?>
					
				</p>
				
				<p style="padding:0 0 10px 0;margin:0;line-height:0;">
					<?php echo $signature_img; ?>
				</p>
					
				<p style="font-size:14px;font-family: 'Roboto', sans-serif;	padding:0 0 15px 0;margin:0;line-height:25px;font-weight:bold;">
				<span style="width:150px;border-top:1px solid #000;display:block;margin:0 0 10px 0;"></span>
					
					<?php echo $signature_text; ?>
				
				<span style="width:100%;border-top:1px solid #000;display:block;margin:10px 0 0 0;"></span>
				</p>
				
				<div style="width:50%;margin:0px 0 0 0;display:inline-block;">
					<p style="font-size:14px;font-family: 'Roboto', sans-serif;	padding:0 0 15px 0;margin:0;line-height:5px;">
						<strong>Date:</strong>  <?php echo $current_date; ?></span>
					</p>
				</div>
			</div>		
		</section>
		
	</div>
	
	<br>
						
			
	